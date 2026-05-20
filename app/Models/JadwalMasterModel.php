<?php
namespace App\Models;

class JadwalMasterModel extends BaseCrudModel
{
    protected $table         = 'jadwal_kirim_master';
    protected $primaryKey    = 'id_jadwal';
    // Menggunakan nama kolom yang sesuai dengan database
    protected $allowedFields = ['id_jadwal', 'id_transaksi', 'id_user', 'tanggal_kirim', 'status_acc', 'status_kirim', 'catatan_admin1', 'catatan_admin2'];

    public function generateId() {
        $lastData = $this->orderBy('id_jadwal', 'DESC')->first();
        if (!$lastData || strlen($lastData['id_jadwal']) > 10) { // Reset jika masih pakai format lama
            return 'JD-001';
        }
        $lastNum = (int) substr($lastData['id_jadwal'], 3);
        return 'JD-' . str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
    }

    public function getJadwalWithPO() {
        return $this->select('jadwal_kirim_master.*, transaksi_beli_master.no_transaksi, supplier.nama_supplier')
                    ->join('transaksi_beli_master', 'transaksi_beli_master.id_transaksi = jadwal_kirim_master.id_transaksi')
                    ->join('supplier', 'supplier.id_supplier = transaksi_beli_master.id_supplier')
                    ->orderBy('jadwal_kirim_master.tanggal_kirim', 'DESC')
                    ->findAll();
    }
}