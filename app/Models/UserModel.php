<?php
namespace App\Models;

class UserModel extends BaseCrudModel
{
    protected $table         = 'users';
    protected $primaryKey    = 'id_user';
    // Tambahkan username ke allowedFields
    protected $allowedFields = ['id_user', 'username', 'nama', 'email', 'password', 'role', 'created_at'];

    // Ganti pencarian login menggunakan username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}