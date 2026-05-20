<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Route Default (Tanpa Login)
$routes->get('/', 'Auth::index');
$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/processLogin', 'Auth::processLogin');
$routes->get('/auth/logout', 'Auth::logout');
$routes->get('/auth/create_first_admin', 'Auth::create_first_admin');

// --------------------------------------------------------------------
// ROUTE TERPROTEKSI (Wajib Login)
// --------------------------------------------------------------------
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // Dashboard & Profil (Semua Role)
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('profil', 'Profil::index');
    $routes->post('profil/update', 'Profil::update');

    // Manajemen Supplier & Katalog (Admin 1)
    $routes->get('supplier', 'Supplier::index');
    $routes->post('supplier/store', 'Supplier::store');
    $routes->post('supplier/update/(:segment)', 'Supplier::update/$1');
    $routes->get('supplier/delete/(:segment)', 'Supplier::delete/$1');
    
    $routes->get('supplier/detail/(:segment)', 'Supplier::detail/$1');
    $routes->post('supplier/store_material', 'Supplier::store_material');
    $routes->post('supplier/update_material/(:segment)', 'Supplier::update_material/$1');
    $routes->get('supplier/delete_material/(:segment)/(:segment)/(:segment)', 'Supplier::delete_material/$1/$2/$3');

    // Analisis Pemilihan (SAW)
    $routes->get('saw', 'AnalisisSAW::index');
    $routes->post('saw/hitung', 'AnalisisSAW::hitung');

    // Transaksi Pembelian (PO)
    $routes->get('pembelian', 'Pembelian::index');
    $routes->get('pembelian/create/(:segment)', 'Pembelian::create/$1');
    $routes->post('pembelian/store', 'Pembelian::store');
    $routes->get('pembelian/cetak_pdf/(:segment)', 'Pembelian::cetak_pdf/$1');

    // Penjadwalan Pengiriman (Admin 1)
    $routes->get('penjadwalan', 'Penjadwalan::index');
    $routes->get('penjadwalan/create/(:segment)', 'Penjadwalan::create/$1');
    $routes->post('penjadwalan/store', 'Penjadwalan::store');
    $routes->post('penjadwalan/update_status/(:segment)', 'Penjadwalan::update_status/$1');

    // Modul Transaksi Pembelian (PO)
    $routes->get('pembelian', 'Pembelian::index');
    $routes->get('pembelian/create/(:segment)', 'Pembelian::create/$1');
    $routes->post('pembelian/store', 'Pembelian::store');
    $routes->get('pembelian/cetak_pdf/(:segment)', 'Pembelian::cetak_pdf/$1');
    // Tambahkan baris ini untuk menghapus PO
    $routes->get('pembelian/delete/(:segment)', 'Pembelian::delete/$1');
});