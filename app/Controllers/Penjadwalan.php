<?php
namespace App\Controllers;

use App\Models\TransaksiMasterModel;
use App\Models\TransaksiDetailModel;
use App\Models\JadwalMasterModel;
use App\Models\JadwalDetailModel;

class Penjadwalan extends BaseController
{
    protected $poMaster, $poDetail, $jadwalMaster, $jadwalDetail;

    public function __construct() {
        $this->poMaster     = new TransaksiMasterModel();
        $this->poDetail     = new TransaksiDetailModel();
        $this->jadwalMaster = new JadwalMasterModel();
        $this->jadwalDetail = new JadwalDetailModel();
    }

    public function index() {
        // 1. Ambil semua PO
        $semua_po = $this->poMaster->getPoWithDetails();
        $po_tersedia = [];

        // 2. Filter PO: Hanya tampilkan PO yang materialnya MASIH ADA SISA
        foreach ($semua_po as $po) {
            $details = $this->poDetail->getDetailByTransaksi($po['id_transaksi']);
            $ada_sisa = false;

            foreach ($details as $d) {
                // Hitung berapa Qty yang sudah pernah masuk ke Jadwal
                $sudah_dijadwal = $this->jadwalDetail->selectSum('qty_kirim')
                                                     ->where('id_detail_transaksi', $d['id_detail_transaksi'])
                                                     ->first();
                
                $total_sudah = $sudah_dijadwal['qty_kirim'] ?? 0;
                $sisa = $d['qty'] - $total_sudah;

                if ($sisa > 0) {
                    $ada_sisa = true;
                    break; // Cukup 1 material saja yang sisa, PO ini tetap tampil
                }
            }

            if ($ada_sisa) {
                $po_tersedia[] = $po;
            }
        }

        $data = [
            'title'     => 'Manajemen Jadwal Pengiriman',
            'transaksi' => $po_tersedia, // Menggunakan array PO yang sudah difilter
            'jadwal'    => $this->jadwalMaster->getJadwalWithPO()
        ];
        return view('admin1/penjadwalan/index', $data);
    }

    public function create($id_transaksi) {
        $master = $this->poMaster->getDataById($id_transaksi);
        if (!$master) return redirect()->to('/penjadwalan');

        $details = $this->poDetail->getDetailByTransaksi($id_transaksi);
        $detail_dengan_sisa = [];

        // Hitung sisa untuk masing-masing material di form Create
        foreach ($details as $d) {
            $sudah_dijadwal = $this->jadwalDetail->selectSum('qty_kirim')
                                                 ->where('id_detail_transaksi', $d['id_detail_transaksi'])
                                                 ->first();
            
            $total_sudah = $sudah_dijadwal['qty_kirim'] ?? 0;
            $qty_sisa = $d['qty'] - $total_sudah;

            if ($qty_sisa > 0) {
                $d['qty_sisa'] = $qty_sisa; // Suntikkan array key qty_sisa untuk view
                $detail_dengan_sisa[] = $d;
            }
        }

        // Jika kebetulan diakses tapi sudah lunas
        if (empty($detail_dengan_sisa)) {
            return redirect()->to('/penjadwalan')->with('error', 'Semua material pada PO ini sudah lunas dijadwalkan.');
        }

        $data = [
            'title'  => 'Buat Jadwal Pengiriman: ' . $master['no_transaksi'],
            'po'     => $master,
            'detail' => $detail_dengan_sisa // Hanya kirim material yang masih ada sisa
        ];
        return view('admin1/penjadwalan/create', $data);
    }

    public function store() {
        $id_transaksi  = $this->request->getPost('id_transaksi');
        $tanggal_kirim = $this->request->getPost('tanggal_kirim');
        $id_jadwal     = $this->jadwalMaster->generateId();

        $dipilih_arr   = $this->request->getPost('dipilih'); 
        $qty_kirim_arr = $this->request->getPost('qty_kirim'); 

        if (empty($dipilih_arr)) {
            return redirect()->back()->with('error', 'Gagal! Pilih minimal 1 material yang akan dijadwalkan.');
        }

        $this->jadwalMaster->insertData([
            'id_jadwal'     => $id_jadwal,
            'id_transaksi'  => $id_transaksi,
            'id_user'       => session()->get('id_user'), 
            'tanggal_kirim' => $tanggal_kirim,
            'status_kirim'  => 'dijadwalkan'
        ]);

        $detail_data = [];
        $i = 1;
        foreach ($dipilih_arr as $id_detail) {
            $qty_dikirim = (int) $qty_kirim_arr[$id_detail];
            
            if ($qty_dikirim > 0) {
                $detail_data[] = [
                    'id_jadwal_detail'    => $id_jadwal . '-' . $i,
                    'id_jadwal'           => $id_jadwal,
                    'id_detail_transaksi' => $id_detail,
                    'qty_kirim'           => $qty_dikirim,
                    'qty_terima'          => 0
                ];
                $i++;
            }
        }

        if (!empty($detail_data)) {
            $this->jadwalDetail->insertBatch($detail_data);
        }

        return redirect()->to('/penjadwalan')->with('success', 'Jadwal pengiriman berhasil dibuat!');
    }

    public function update_status($id_jadwal) {
        $status = $this->request->getPost('status_kirim');
        $this->jadwalMaster->updateData($id_jadwal, [
            'status_kirim' => $status
        ]);
        return redirect()->to('/penjadwalan')->with('success', 'Status jadwal pengiriman berhasil diperbarui!');
    }
}