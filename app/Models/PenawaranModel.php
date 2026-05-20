<?php
namespace App\Models;

class PenawaranModel extends BaseCrudModel
{
    protected $table         = 'penawaran_supplier';
    protected $primaryKey    = 'id_penawaran';
    protected $allowedFields = ['id_penawaran', 'id_supplier', 'id_material', 'harga', 'waktu_kirim', 'stok_supplier'];

    public function generateId() {
        $lastData = $this->orderBy('id_penawaran', 'DESC')->first();
        if (!$lastData) return 'PNW-001';
        $lastNum = (int) substr($lastData['id_penawaran'], 4);
        return 'PNW-' . str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
    }

    public function getMaterialBySupplier($id_supplier) {
        return $this->select('penawaran_supplier.*, material.nama_material, material.spesifikasi, material.satuan')
                    ->join('material', 'material.id_material = penawaran_supplier.id_material')
                    ->where('id_supplier', $id_supplier)
                    ->findAll();
    }

public function getUniqueKatalogNames() {
        return $this->select('material.nama_material, material.satuan')
                    ->join('material', 'material.id_material = penawaran_supplier.id_material')
                    ->groupBy(['material.nama_material', 'material.satuan']) 
                    ->findAll();
    }

    public function getPenawaranByMaterialName($nama_material) {
        return $this->select('penawaran_supplier.*, supplier.nama_supplier, material.nama_material, material.satuan')
                    ->join('supplier', 'supplier.id_supplier = penawaran_supplier.id_supplier')
                    ->join('material', 'material.id_material = penawaran_supplier.id_material')
                    ->where('material.nama_material', $nama_material)
                    ->findAll();
    }

    // Fungsi ini yang sebelumnya ter-copy ganda, sekarang sudah disisakan 1 saja
    public function getPenawaranDetailById($id_penawaran) {
        return $this->select('penawaran_supplier.*, material.nama_material, material.spesifikasi, material.satuan')
                    ->join('material', 'material.id_material = penawaran_supplier.id_material')
                    ->where('id_penawaran', $id_penawaran)
                    ->first();
    }
}