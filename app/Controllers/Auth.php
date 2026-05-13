<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Auth extends Controller
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $db->initialize();

            return "Koneksi database berhasil!";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}