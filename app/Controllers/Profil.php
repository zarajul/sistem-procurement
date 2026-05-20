<?php
namespace App\Controllers;

use App\Models\UserModel;

class Profil extends BaseController
{
    protected $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function index() {
        $id_user = session()->get('id_user');
        $data = [
            'title' => 'Kelola Profil',
            'user'  => $this->userModel->getDataById($id_user)
        ];
        return view('profil/index', $data); 
    }

    public function update() {
        $id_user = session()->get('id_user');
        
        $username_baru = $this->request->getPost('username');
        $nama_baru     = $this->request->getPost('nama');
        $email_baru    = $this->request->getPost('email');
        
        // Tangkap input password
        $password_lama       = $this->request->getPost('password_lama');
        $password_baru       = $this->request->getPost('password_baru');
        $konfirmasi_password = $this->request->getPost('konfirmasi_password');

        // Cek duplikasi username
        $cek_username = $this->userModel->where('username', $username_baru)->where('id_user !=', $id_user)->first();
        if ($cek_username) {
            return redirect()->to('/profil')->with('error', 'Username tersebut sudah dipakai orang lain!');
        }

        $dataUpdate = [
            'username' => $username_baru,
            'nama'     => $nama_baru,
            'email'    => $email_baru
        ];

        // Jika salah satu field password diisi, lakukan proses validasi ganti password
        if (!empty($password_lama) || !empty($password_baru) || !empty($konfirmasi_password)) {
            $user_saat_ini = $this->userModel->getDataById($id_user);

            // 1. Verifikasi password lama
            if (!password_verify($password_lama, $user_saat_ini['password'])) {
                return redirect()->to('/profil')->with('error', 'Gagal! Password lama yang Anda masukkan salah.');
            }

            // 2. Verifikasi kesamaan password baru dan konfirmasi
            if ($password_baru !== $konfirmasi_password) {
                return redirect()->to('/profil')->with('error', 'Gagal! Konfirmasi password baru tidak cocok.');
            }

            // 3. Enkripsi dan masukkan ke data update
            $dataUpdate['password'] = password_hash($password_baru, PASSWORD_DEFAULT);
        }

        $this->userModel->updateData($id_user, $dataUpdate);

        // Update Sesi Terbaru
        session()->set('username', $username_baru);
        session()->set('nama', $nama_baru);
        session()->set('email', $email_baru);

        return redirect()->to('/profil')->with('success', 'Profil berhasil diperbarui!');
    }
}