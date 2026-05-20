<?php
namespace App\Controllers;
use App\Models\SupplierModel;
use App\Models\MaterialModel;
use App\Models\PenawaranModel;

class Supplier extends BaseController
{
    protected $supplierModel;
    protected $materialModel;
    protected $penawaranModel;

    public function __construct() {
        $this->supplierModel = new SupplierModel();
        $this->materialModel = new MaterialModel();
        $this->penawaranModel = new PenawaranModel();
    }

    // --- BAGIAN 1: CRUD SUPPLIER ---
    public function index() {
        $data = [
            'title' => 'Manajemen Supplier',
            'suppliers' => $this->supplierModel->getAllData()
        ];
        return view('admin1/supplier/index', $data);
    }

    public function store() {
        $data = [
            'id_supplier'   => $this->supplierModel->generateId(),
            'nama_supplier' => $this->request->getPost('nama_supplier'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_telp'       => $this->request->getPost('no_telp')
        ];
        $this->supplierModel->insertData($data);
        return redirect()->to('/supplier')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function update($id) {
        $data = [
            'nama_supplier' => $this->request->getPost('nama_supplier'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_telp'       => $this->request->getPost('no_telp')
        ];
        $this->supplierModel->updateData($id, $data);
        return redirect()->to('/supplier')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function delete($id) {
        $this->supplierModel->deleteData($id);
        return redirect()->to('/supplier')->with('success', 'Supplier berhasil dihapus.');
    }


    // --- BAGIAN 2: CRUD MATERIAL MILIK SUPPLIER ---
    public function detail($id) {
        $supplier = $this->supplierModel->getDataById($id);
        if (!$supplier) return redirect()->to('/supplier');

        $data = [
            'title'    => 'Material: ' . $supplier['nama_supplier'],
            'supplier' => $supplier,
            'katalog'  => $this->penawaranModel->getMaterialBySupplier($id)
        ];
        return view('admin1/supplier/detail', $data);
    }

    public function store_material() {
        $id_supplier = $this->request->getPost('id_supplier');
        $id_material = $this->materialModel->generateId();

        // 1. Simpan ke tabel material
        $this->materialModel->insertData([
            'id_material'   => $id_material,
            'nama_material' => $this->request->getPost('nama_material'),
            'spesifikasi'   => $this->request->getPost('spesifikasi'),
            'satuan'        => $this->request->getPost('satuan')
        ]);

        // 2. Simpan ke tabel penawaran_supplier
        $this->penawaranModel->insertData([
            'id_penawaran'  => $this->penawaranModel->generateId(),
            'id_supplier'   => $id_supplier,
            'id_material'   => $id_material,
            'harga'         => $this->request->getPost('harga'),
            'waktu_kirim'   => $this->request->getPost('waktu_kirim'),
            'stok_supplier' => $this->request->getPost('stok_supplier')
        ]);

        return redirect()->to('/supplier/detail/' . $id_supplier)->with('success', 'Material baru berhasil ditambahkan.');
    }

    public function update_material($id_penawaran) {
        $id_supplier = $this->request->getPost('id_supplier');
        $id_material = $this->request->getPost('id_material');

        // Update Material
        $this->materialModel->updateData($id_material, [
            'nama_material' => $this->request->getPost('nama_material'),
            'spesifikasi'   => $this->request->getPost('spesifikasi'),
            'satuan'        => $this->request->getPost('satuan')
        ]);

        // Update Penawaran
        $this->penawaranModel->updateData($id_penawaran, [
            'harga'         => $this->request->getPost('harga'),
            'waktu_kirim'   => $this->request->getPost('waktu_kirim'),
            'stok_supplier' => $this->request->getPost('stok_supplier')
        ]);

        return redirect()->to('/supplier/detail/' . $id_supplier)->with('success', 'Data material berhasil diperbarui.');
    }

    public function delete_material($id_penawaran, $id_supplier, $id_material) {
        // Hapus penawaran dan materialnya
        $this->penawaranModel->deleteData($id_penawaran);
        $this->materialModel->deleteData($id_material);
        
        return redirect()->to('/supplier/detail/' . $id_supplier)->with('success', 'Material berhasil dihapus.');
    }
}