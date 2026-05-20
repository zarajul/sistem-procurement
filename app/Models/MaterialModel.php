<?php
namespace App\Models;

class MaterialModel extends BaseCrudModel
{
    protected $table         = 'material';
    protected $primaryKey    = 'id_material';
    protected $allowedFields = ['id_material', 'nama_material', 'spesifikasi', 'satuan'];

    public function generateId() {
        $lastData = $this->orderBy('id_material', 'DESC')->first();
        if (!$lastData) return 'MAT-001';
        $lastNum = (int) substr($lastData['id_material'], 4);
        return 'MAT-' . str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
    }
}