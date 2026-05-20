<?= $this->extend('layout/admin_layout') ?>
<?= $this->section('content') ?>

<h4 class="fw-bold mb-1" style="color: #000000;">ANALISIS PEMILIHAN SUPPLIER</h4>
<p class="text-secondary mb-4">Pilih material yang dibutuhkan. Sistem akan mengumpulkan seluruh supplier yang menjual barang ini dan merangkingnya.</p>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger rounded-3 small py-2"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="card card-custom p-4 border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Material (Katalog Tersedia)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($katalog_unik as $k): ?>
                <tr>
                    <td class="text-dark"><?= $no++ ?></td>
                    <td>
                        <span class="fw-bold text-dark fs-6"><?= esc($k['nama_material']) ?></span>
                        <span class="badge bg-light text-dark border ms-2"><?= esc($k['satuan']) ?></span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-custom-primary px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#hitungModal<?= base64_encode($k['nama_material']) ?>">
                            Bandingkan Supplier ➔
                        </button>
                    </td>
                </tr>

                <div class="modal fade" id="hitungModal<?= base64_encode($k['nama_material']) ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content border-0 rounded-4 text-start">
                            <form action="<?= base_url('saw/hitung') ?>" method="POST">
                                <input type="hidden" name="nama_material" value="<?= esc($k['nama_material']) ?>">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Kebutuhan: <?= esc($k['nama_material']) ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="small text-secondary mb-3">Masukkan kuantitas material yang diperlukan proyek untuk menguji rasio kecukupan stok dari masing-masing supplier.</p>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Jumlah Kebutuhan</label>
                                        <div class="input-group">
                                            <input type="number" name="qty_kebutuhan" class="form-control" placeholder="Contoh: 100" min="1" required>
                                            <span class="input-group-text bg-light text-secondary small"><?= esc($k['satuan']) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="submit" class="btn btn-custom-primary w-100">Mulai Analisis</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>