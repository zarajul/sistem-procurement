<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Interfaces\CrudInterface;

class BaseCrudModel extends Model implements CrudInterface
{
    // Property bawaan CI4 yang akan di-override oleh child class
    protected $table      = '';
    protected $primaryKey = '';
    protected $allowedFields = [];

    /**
     * Mengambil semua data dari tabel
     */
    public function getAllData()
    {
        return $this->findAll();
    }

    /**
     * Mengambil data berdasarkan ID
     */
    public function getDataById($id)
    {
        return $this->where($this->primaryKey, $id)->first();
    }

    /**
     * Memasukkan data baru
     * Menggunakan try-catch untuk error handling
     */
    public function insertData(array $data)
    {
        try {
            $this->insert($data);
            return $this->getInsertID();
        } catch (\Exception $e) {
            log_message('error', '[Insert Error] ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Memperbarui data
     */
    public function updateData($id, array $data)
    {
        try {
            return $this->update($id, $data);
        } catch (\Exception $e) {
            log_message('error', '[Update Error] ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Menghapus data
     */
    public function deleteData($id)
    {
        try {
            return $this->delete($id);
        } catch (\Exception $e) {
            log_message('error', '[Delete Error] ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mencari data berdasarkan keyword (Akan di-override di child class sesuai kolom)
     */
    public function searchData($keyword)
    {
        // Default pencarian berdasarkan primary key (bisa dimodifikasi di child class)
        return $this->like($this->primaryKey, $keyword)->findAll();
    }
}