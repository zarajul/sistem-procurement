<?php
namespace App\Controllers;

use App\Models\PenawaranModel;

class AnalisisSAW extends BaseController
{
    protected $penawaranModel;

    public function __construct() {
        $this->penawaranModel = new PenawaranModel();
    }

    public function index() {
        $data = [
            'title'        => 'Analisis Pemilihan Supplier (SAW)',
            'katalog_unik' => $this->penawaranModel->getUniqueKatalogNames()
        ];
        return view('admin1/saw/index', $data);
    }

    public function hitung() {
        $nama_material = $this->request->getPost('nama_material');
        $qty_kebutuhan = (int) $this->request->getPost('qty_kebutuhan');

        if ($qty_kebutuhan <= 0) {
            return redirect()->to('/saw')->with('error', 'Jumlah kebutuhan material harus lebih dari 0.');
        }

        $penawaran = $this->penawaranModel->getPenawaranByMaterialName($nama_material);

        if (count($penawaran) < 1) {
            return redirect()->to('/saw')->with('error', 'Belum ada supplier yang menawarkan material ini.');
        }

        $w_harga        = 0.50; // Cost
        $w_ketersediaan = 0.30; // Benefit
        $w_waktu        = 0.20; // Cost

        $matriks_x = [];
        foreach ($penawaran as $p) {
            $ketersediaan_dinamis = $p['stok_supplier'] / $qty_kebutuhan;

            $matriks_x[] = [
                'id_supplier'   => $p['id_supplier'],
                'nama_supplier' => $p['nama_supplier'],
                'harga'         => (float) ($p['harga'] > 0 ? $p['harga'] : 1), 
                'waktu_kirim'   => (float) ($p['waktu_kirim'] > 0 ? $p['waktu_kirim'] : 1),
                'stok_supplier' => (int) $p['stok_supplier'],
                'ketersediaan'  => $ketersediaan_dinamis,
                'satuan'        => $p['satuan']
            ];
        }

        $minHarga = min(array_column($matriks_x, 'harga'));
        $maxStok  = max(array_column($matriks_x, 'ketersediaan'));
        $minWaktu = min(array_column($matriks_x, 'waktu_kirim'));

        $hasil_ranking = [];

        foreach ($matriks_x as $x) {
            $r_harga        = $minHarga / $x['harga'];
            $r_ketersediaan = ($maxStok > 0) ? ($x['ketersediaan'] / $maxStok) : 0;
            $r_waktu        = $minWaktu / $x['waktu_kirim'];

            $nilai_v = ($w_harga * $r_harga) + ($w_ketersediaan * $r_ketersediaan) + ($w_waktu * $r_waktu);

            // Hitung persentase asli (misal: 150.5%)
            $persen_asli = round(($x['ketersediaan'] * 100), 1);
            
            // Batasi nilai maksimal menjadi 100% untuk tampilan UI
            $persen_tampil = min(100, $persen_asli);

            $hasil_ranking[] = [
                'id_supplier'   => $x['id_supplier'],
                'nama_supplier' => $x['nama_supplier'],
                'harga'         => $x['harga'],
                'waktu_kirim'   => $x['waktu_kirim'],
                'stok_supplier' => $x['stok_supplier'],
                'persen_pemuasan'=> $persen_tampil, // Gunakan nilai yang sudah dibatasi
                'skor_akhir'    => round($nilai_v, 4)
            ];
        }

        usort($hasil_ranking, function($a, $b) {
            return $b['skor_akhir'] <=> $a['skor_akhir'];
        });

        $data = [
            'title'         => 'Hasil Analisis: ' . $nama_material,
            'nama_material' => $nama_material,
            'satuan'        => $penawaran[0]['satuan'],
            'qty_kebutuhan' => $qty_kebutuhan,
            'ranking'       => $hasil_ranking
        ];

        return view('admin1/saw/hasil', $data);
    }
}