<?php
namespace App\Models;

class TransaksiMasterModel extends BaseCrudModel
{
    protected $table         = 'transaksi_beli_master';
    protected $primaryKey    = 'id_transaksi';
    protected $allowedFields = ['id_transaksi', 'no_transaksi', 'id_supplier', 'id_user', 'tanggal_transaksi', 'subject', 'total', 'ppn', 'lokasi_kirim', 'tanggal_kirim'];

    public function generateId() {
        $lastData = $this->orderBy('id_transaksi', 'DESC')->first();
        if (!$lastData) return 'TRX-001';
        $lastNum = (int) substr($lastData['id_transaksi'], 4);
        return 'TRX-' . str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
    }

    public function generateNoPO() {
        $lastData = $this->orderBy('id_transaksi', 'DESC')->first();
        if (!$lastData || strpos($lastData['no_transaksi'], '/') === false) {
            return '1/PO/HIS/BM/MS-KM92';
        }
        $parts = explode('/', $lastData['no_transaksi']);
        $lastNum = (int) $parts[0];
        return ($lastNum + 1) . '/PO/HIS/BM/MS-KM92';
    }

    public function getPoWithDetails() {
        return $this->select('transaksi_beli_master.*, supplier.nama_supplier, users.nama as nama_admin')
                    ->join('supplier', 'supplier.id_supplier = transaksi_beli_master.id_supplier')
                    ->join('users', 'users.id_user = transaksi_beli_master.id_user')
                    ->orderBy('tanggal_transaksi', 'DESC')
                    ->findAll();
    }

    /**
     * FUNGSI BARU UNTUK CETAK PDF
     * Mengambil 1 data PO spesifik berdasarkan ID beserta detail nama admin pembuatnya
     */
    public function getPoByIdWithDetails($id_transaksi) {
        return $this->select('transaksi_beli_master.*, supplier.nama_supplier, users.nama as nama_admin')
                    ->join('supplier', 'supplier.id_supplier = transaksi_beli_master.id_supplier')
                    ->join('users', 'users.id_user = transaksi_beli_master.id_user')
                    ->where('transaksi_beli_master.id_transaksi', $id_transaksi)
                    ->first(); // Gunakan first() karena kita hanya butuh 1 baris data
    }

    /**
     * Menampilkan PO yang MASIH memiliki item dengan kuantitas belum terjadwal penuh
     */
    public function getPoAvailableForScheduling() {
        $db = \Config\Database::connect();
        
        // Subquery untuk mendeteksi ID Transaksi yang itemnya masih memiliki sisa qty
        $subquery = $db->table('transaksi_beli_detail tbd')
            ->select('tbd.id_transaksi')
            ->join('(SELECT id_detail_transaksi, SUM(qty_kirim) as total_terjadwal FROM jadwal_kirim_detail GROUP BY id_detail_transaksi) jkd', 'jkd.id_detail_transaksi = tbd.id_detail_transaksi', 'left')
            ->where('tbd.qty > COALESCE(jkd.total_terjadwal, 0)')
            ->groupBy('tbd.id_transaksi')
            ->getCompiledSelect();

        return $this->select('transaksi_beli_master.*, supplier.nama_supplier, users.nama as nama_admin')
                    ->join('supplier', 'supplier.id_supplier = transaksi_beli_master.id_supplier')
                    ->join('users', 'users.id_user = transaksi_beli_master.id_user')
                    ->where("transaksi_beli_master.id_transaksi IN ($subquery)")
                    ->orderBy('tanggal_transaksi', 'DESC')
                    ->findAll();
    }
}