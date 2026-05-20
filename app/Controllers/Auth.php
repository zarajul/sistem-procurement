<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/landing_page');
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

public function processLogin()
    {
        $username = $this->request->getPost('username'); 
        $password = $this->request->getPost('password');

        $user = $this->userModel->getUserByUsername($username);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'id_user'    => $user['id_user'],
                    'username'   => $user['username'], // Simpan username
                    'nama'       => $user['nama'],     // Simpan nama asli
                    'email'      => $user['email'],
                    'role'       => $user['role'],
                    'isLoggedIn' => true
                ];
                session()->set($sessionData);
                return redirect()->to('/dashboard');
            } else {
                return redirect()->to('/auth/login')->with('error', 'Password salah!');
            }
        } else {
            return redirect()->to('/auth/login')->with('error', 'Username tidak ditemukan!');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Anda berhasil logout.');
    }

    // Akses URL: http://sistem-procurement/auth/create_first_admin
    public function create_first_admin()
    {
        $data = [
            'id_user'  => 'USR-001',
            'nama'     => 'Master Admin', // Ini akan menjadi Username saat login
            'email'    => 'admin@hakiki.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role'     => 'admin1'
        ];
        
        if(!$this->userModel->getUserByNama($data['nama'])) {
            $this->userModel->insertData($data);
            echo "Akun berhasil dibuat! Username: Master Admin | Pass: admin123";
        } else {
            echo "Akun sudah ada!";
        }
    }
}