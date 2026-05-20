<?php
namespace App\Models;

class SupplierModel extends BaseCrudModel
{
    protected $table         = 'supplier';
    protected $primaryKey    = 'id_supplier';
    protected $allowedFields = ['id_supplier', 'nama_supplier', 'alamat', 'no_telp', 'created_at'];

    public function generateId() {
        $lastData = $this->orderBy('id_supplier', 'DESC')->first();
        if (!$lastData) return 'SUP-001';
        $lastNum = (int) substr($lastData['id_supplier'], 4);
        return 'SUP-' . str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
    }
}