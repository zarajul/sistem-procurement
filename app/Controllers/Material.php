<?php
namespace App\Controllers;
use App\Models\MaterialModel;

class Material extends BaseController
{
    protected $materialModel;

    public function __construct() {
        $this->materialModel = new MaterialModel();
    }

    public function index() {
        if(session()->get('role') != 'admin1') return redirect()->to('/dashboard');
        $data = [
            'title' => 'Data Material',
            'materials' => $this->materialModel->getAllData()
        ];
        return view('admin1/material/index', $data);
    }

    public function store() {
        $data = [
            'id_material'   => $this->materialModel->generateId(),
            'nama_material' => $this->request->getPost('nama_material'),
            'spesifikasi'   => $this->request->getPost('spesifikasi'),
            'satuan'        => $this->request->getPost('satuan')
        ];
        $this->materialModel->insertData($data);
        return redirect()->to('/material')->with('success', 'Material berhasil ditambahkan.');
    }

    public function update($id) {
        $data = [
            'nama_material' => $this->request->getPost('nama_material'),
            'spesifikasi'   => $this->request->getPost('spesifikasi'),
            'satuan'        => $this->request->getPost('satuan')
        ];
        $this->materialModel->updateData($id, $data);
        return redirect()->to('/material')->with('success', 'Data Material berhasil diperbarui.');
    }

    public function delete($id) {
        $this->materialModel->deleteData($id);
        return redirect()->to('/material')->with('success', 'Material berhasil dihapus.');
    }
}