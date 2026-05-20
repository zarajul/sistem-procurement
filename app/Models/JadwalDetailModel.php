<?php
namespace App\Models;

class JadwalDetailModel extends BaseCrudModel
{
    protected $table         = 'jadwal_kirim_detail';
    protected $primaryKey    = 'id_jadwal_detail';
    protected $allowedFields = ['id_jadwal_detail', 'id_jadwal', 'id_detail_transaksi', 'qty_kirim', 'qty_terima', 'status_material', 'catatan'];

    public function getDetailWithMaterial($id_jadwal) {
        return $this->select('jadwal_kirim_detail.*, transaksi_beli_detail.qty as qty_po, material.nama_material, transaksi_beli_detail.satuan')
                    ->join('transaksi_beli_detail', 'transaksi_beli_detail.id_detail_transaksi = jadwal_kirim_detail.id_detail_transaksi')
                    ->join('material', 'material.id_material = transaksi_beli_detail.id_material')
                    ->where('id_jadwal', $id_jadwal)
                    ->findAll();
    }
}