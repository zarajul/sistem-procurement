<?php
namespace App\Controllers;

use App\Models\TransaksiMasterModel;
use App\Models\TransaksiDetailModel;
use App\Models\SupplierModel;
use App\Models\PenawaranModel;
use Dompdf\Dompdf;

class Pembelian extends BaseController
{
    protected $poMaster, $poDetail, $supplierModel, $penawaranModel;

    public function __construct() {
        $this->poMaster = new TransaksiMasterModel();
        $this->poDetail = new TransaksiDetailModel();
        $this->supplierModel = new SupplierModel();
        $this->penawaranModel = new PenawaranModel();
    }

    public function index() {
        $data = [
            'title' => 'Daftar Purchase Order (PO)',
            'transaksi' => $this->poMaster->getPoWithDetails()
        ];
        return view('admin1/pembelian/index', $data);
    }

    public function create($id_supplier = null) {
        if (!$id_supplier) {
            return redirect()->to('/supplier')->with('error', 'Pilih supplier terlebih dahulu.');
        }

        $data = [
            'title'    => 'Buat Purchase Order',
            'supplier' => $this->supplierModel->getDataById($id_supplier),
            'katalog'  => $this->penawaranModel->getMaterialBySupplier($id_supplier) 
        ];
        return view('admin1/pembelian/create', $data);
    }

    public function store() {
        $id_transaksi = $this->poMaster->generateId();
        $no_transaksi = $this->poMaster->generateNoPO(); // Panggil template nomor PO
        $id_supplier  = $this->request->getPost('id_supplier');
        
        $id_penawaran_arr = $this->request->getPost('id_penawaran'); 
        $qty_arr          = $this->request->getPost('qty'); 
        
        $total_nilai = 0;
        $detail_data = [];

        for ($i = 0; $i < count($id_penawaran_arr); $i++) {
            // Gunakan fungsi baru yang sudah di-join dengan tabel material
            $penawaran = $this->penawaranModel->getPenawaranDetailById($id_penawaran_arr[$i]);
            
            $subtotal = $penawaran['harga'] * $qty_arr[$i];
            $total_nilai += $subtotal;

            $detail_data[] = [
                'id_detail_transaksi' => $id_transaksi . '-' . ($i+1), 
                'id_transaksi' => $id_transaksi,
                'id_material'  => $penawaran['id_material'],
                'id_penawaran' => $penawaran['id_penawaran'],
                'qty'          => $qty_arr[$i],
                'harga'        => $penawaran['harga'], 
                'satuan'       => $penawaran['satuan'], // Sekarang ini akan terbaca dengan aman!
                'subtotal'     => $subtotal
            ];
        }

        // Simpan Master
        $this->poMaster->insertData([
            'id_transaksi'      => $id_transaksi,
            'no_transaksi'      => $no_transaksi, // Masukkan nomor PO format PT Hakiki
            'id_supplier'       => $id_supplier,
            'id_user'           => session()->get('id_user'),
            'tanggal_transaksi' => date('Y-m-d'),
            'total'             => $total_nilai
        ]);

        $this->poDetail->insertBatch($detail_data);
        return redirect()->to('/pembelian')->with('success', 'Purchase Order berhasil dibuat!');
    }

        public function cetak_pdf($id_transaksi) {
        $master = $this->poMaster->getPoByIdWithDetails($id_transaksi);
        
        $supplier = $this->supplierModel->getDataById($master['id_supplier']);
        $detail = $this->poDetail->getDetailByTransaksi($id_transaksi);

        $data = [
            'po'       => $master,
            'supplier' => $supplier,
            'detail'   => $detail
        ];

        $html = view('admin1/pembelian/pdf_template', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $dompdf->stream("PO_Hakiki_" . $id_transaksi . ".pdf", ["Attachment" => 0]);
    }

    // Hapus Purchase Order
    public function delete($id_transaksi) {
        // Hapus data master. (Data detail akan ikut terhapus otomatis karena foreign key ON DELETE CASCADE)
        $this->poMaster->deleteData($id_transaksi);
        
        return redirect()->to('/pembelian')->with('success', 'Data Purchase Order berhasil dihapus!');
    }
}