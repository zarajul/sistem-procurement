<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard Utama',
            'nama'  => session()->get('nama'),
            'role'  => session()->get('role')
        ];
        return view('dashboard/index', $data);
    }
}