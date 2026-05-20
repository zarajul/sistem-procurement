<?= $this->extend('layout/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="<?= base_url('saw') ?>" class="text-decoration-none small text-secondary">← Kembali ke Daftar Material</a>
    <h5 class="fw-bold mt-2" style="color: #000000;">HASIL ANALISIS: <?= esc($nama_material) ?></h5>
    <p class="text-secondary small">Berdasarkan kebutuhan proyek: <strong><?= $qty_kebutuhan ?> <?= esc($satuan) ?></strong></p>
</div>

<h6 class="fw-bold text-dark mb-3">TOP 3 KANDIDAT SUPPLIER</h6>
<div class="row mb-4">
    <?php 
    // Ambil maksimal 3 data teratas
    $top3 = array_slice($ranking, 0, 3); 
    $medals = [' #1', ' #2', ' #3'];
    $colors = ['#494d11', '#546e7a', '#8d6e63']; 
    
    foreach($top3 as $index => $r): 
    ?>
    <div class="col-md-4 mb-3">
        <div class="card h-100 border-0 shadow-sm" style="border-top: 4px solid <?= $colors[$index] ?> !important; border-radius: 10px;">
            <div class="card-body text-center position-relative p-4">
                <span class="badge position-absolute top-0 start-50 translate-middle rounded-pill" style="background-color: <?= $colors[$index] ?>; font-size: 0.85rem;">
                    <?= $medals[$index] ?>
                </span>
                
                <h5 class="fw-bold mt-3 mb-1 text-dark"><?= esc($r['nama_supplier']) ?></h5>
                <h3 class="fw-bold text-brown mb-3"><?= $r['skor_akhir'] ?></h3>
                
                <div class="small text-secondary mb-3 text-start bg-light p-2 rounded">
                    <div class="d-flex justify-content-between border-bottom pb-1 mb-1">
                        <span>Harga</span> <strong class="text-dark">Rp <?= number_format($r['harga'], 0, ',', '.') ?></strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-1 mb-1">
                        <span>Ketersediaan</span> 
                        <strong class="<?= $r['persen_pemuasan'] >= 100 ? 'text-success' : 'text-danger' ?>">
                            <?= $r['persen_pemuasan'] ?>% 
                        </strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Waktu Kirim</span> <strong class="text-dark"><?= $r['waktu_kirim'] ?> Hari</strong>
                    </div>
                </div>

                <a href="<?= base_url('pembelian/create/'.$r['id_supplier']) ?>" class="btn btn-outline-dark btn-sm w-100 rounded-pill fw-bold">
                    Pilih & Buat PO
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="card card-custom p-4 border-0 shadow-sm">
    <h6 class="fw-bold mb-3 text-dark">Detail Perhitungan Seluruh Supplier</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Rank</th>
                    <th>Nama Supplier</th>
                    <th>Harga</th>
                    <th>Ketersediaan</th>
                    <th>Waktu</th>
                    <th class="text-center text-brown fw-bold">Skor V</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($ranking as $r): ?>
                <tr>
                    <td class="text-dark">#<?= $no++ ?></td>
                    <td class="text-dark"><?= esc($r['nama_supplier']) ?></td>
                    <td>Rp <?= number_format($r['harga'], 0, ',', '.') ?></td>
                    <td>
                        <span"><?= $r['persen_pemuasan'] ?>%</span><br>
                        <small class="text-muted">Stok: <?= $r['stok_supplier'] ?></small>
                    </td>
                    <td><?= $r['waktu_kirim'] ?> Hari</td>
                    <td class="text-center fw-bold text-brown"><?= $r['skor_akhir'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>