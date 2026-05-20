<?php
namespace App\Models;

class TransaksiDetailModel extends BaseCrudModel
{
    protected $table         = 'transaksi_beli_detail';
    protected $primaryKey    = 'id_detail_transaksi';
    protected $allowedFields = ['id_detail_transaksi', 'id_transaksi', 'id_material', 'id_penawaran', 'qty', 'harga', 'satuan', 'subtotal'];

    public function getDetailByTransaksi($id_transaksi) {
        return $this->select('transaksi_beli_detail.*, material.nama_material')
                    ->join('material', 'material.id_material = transaksi_beli_detail.id_material')
                    ->where('id_transaksi', $id_transaksi)
                    ->findAll();
    }

    /**
     * Mengambil item detail PO yang dikalkulasikan dengan sisa kuantitas yang belum dijadwalkan
     */
    public function getRemainingDetails($id_transaksi) {
        return $this->select('transaksi_beli_detail.*, material.nama_material, (transaksi_beli_detail.qty - COALESCE(jkd.total_terjadwal, 0)) as qty_sisa')
                    ->join('material', 'material.id_material = transaksi_beli_detail.id_material')
                    ->join('(SELECT id_detail_transaksi, SUM(qty_kirim) as total_terjadwal FROM jadwal_kirim_detail GROUP BY id_detail_transaksi) jkd', 'jkd.id_detail_transaksi = transaksi_beli_detail.id_detail_transaksi', 'left')
                    ->where('transaksi_beli_detail.id_transaksi', $id_transaksi)
                    ->where('(transaksi_beli_detail.qty - COALESCE(jkd.total_terjadwal, 0)) >', 0)
                    ->findAll();
    }
}