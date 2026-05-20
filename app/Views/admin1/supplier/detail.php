<?= $this->extend('layout/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="<?= base_url('supplier') ?>" class="text-decoration-none small text-secondary">← Kembali ke Daftar Supplier</a>
    <div class="d-flex justify-content-between align-items-end mt-2">
        <div>
            <h2 class="fw-bold mb-0" style="color: #4d1a11;"><?= esc($supplier['nama_supplier']) ?></h2>
            <p class="text-secondary mb-0"><small><?= esc($supplier['alamat']) ?> | Telp: <?= esc($supplier['no_telp']) ?></small></p>
        </div>
        <button class="btn btn-custom-primary" data-bs-toggle="modal" data-bs-target="#addMaterialModal">+ Tambah Material</button>
    </div>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success rounded-3 small py-2"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card card-custom p-4">
    <h6 class="fw-bold mb-3">Daftar Material yang Dijual</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th width="20%">Nama Material</th>
                    <th width="25%">Spesifikasi</th>
                    <th width="10%">Satuan</th>
                    <th width="15%">Harga (Rp)</th>
                    <th width="12%">Waktu Kirim</th>
                    <th width="8%">Stok</th>
                    <th width="10%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($katalog as $item): ?>
                <tr>
                    <td class="fw-bold text-dark"><?= esc($item['nama_material']) ?></td>
                    <td>
                        <?php 
                            $spek = esc($item['spesifikasi']);
                            if (strlen($spek) > 40) {
                                echo '<span class="text-secondary small">' . substr($spek, 0, 40) . '...</span>';
                                echo ' <a href="#" class="text-decoration-none small text-primary fw-bold ms-1" data-bs-toggle="modal" data-bs-target="#specModal'.$item['id_penawaran'].'">Detail</a>';
                            } else {
                                echo '<span class="text-secondary small">' . ($spek ?: '-') . '</span>';
                            }
                        ?>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border"><?= esc($item['satuan']) ?></span>
                    </td>
                    <td class="fw-bold text-brown">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                    <td><?= $item['waktu_kirim'] ?> Hari</td>
                    <td><?= $item['stok_supplier'] ?></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editMat<?= $item['id_penawaran'] ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                        <a href="<?= base_url('supplier/delete_material/'.$item['id_penawaran'].'/'.$supplier['id_supplier'].'/'.$item['id_material']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus material ini dari supplier?')"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>

                <?php if (strlen($spek) > 40): ?>
                <div class="modal fade" id="specModal<?= $item['id_penawaran'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 rounded-4">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold text-brown">Detail Spesifikasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-wrap text-break">
                                <p class="mb-0 text-secondary" style="line-height: 1.6;"><?= nl2br($spek) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="modal fade text-start" id="editMat<?= $item['id_penawaran'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content border-0 rounded-4">
                            <form action="<?= base_url('supplier/update_material/'.$item['id_penawaran']) ?>" method="POST">
                                <input type="hidden" name="id_supplier" value="<?= $supplier['id_supplier'] ?>">
                                <input type="hidden" name="id_material" value="<?= $item['id_material'] ?>">
                                <div class="modal-header"><h5 class="modal-title fw-bold">Edit Material</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3"><label class="form-label small fw-semibold">Nama Material</label><input type="text" name="nama_material" class="form-control" value="<?= esc($item['nama_material']) ?>" required></div>
                                        <div class="col-md-6 mb-3"><label class="form-label small fw-semibold">Satuan (Misal: Pcs, Kg)</label><input type="text" name="satuan" class="form-control" value="<?= esc($item['satuan']) ?>" required></div>
                                        <div class="col-md-12 mb-3"><label class="form-label small fw-semibold">Spesifikasi</label><input type="text" name="spesifikasi" class="form-control" value="<?= esc($item['spesifikasi']) ?>"></div>
                                        <div class="col-md-4 mb-3"><label class="form-label small fw-semibold">Harga Jual (Rp)</label><input type="number" name="harga" class="form-control" value="<?= esc($item['harga']) ?>" required></div>
                                        <div class="col-md-4 mb-3"><label class="form-label small fw-semibold">Waktu Kirim (Hari)</label><input type="number" name="waktu_kirim" class="form-control" value="<?= esc($item['waktu_kirim']) ?>" required></div>
                                        <div class="col-md-4 mb-3"><label class="form-label small fw-semibold">Stok Saat Ini</label><input type="number" name="stok_supplier" class="form-control" value="<?= esc($item['stok_supplier']) ?>" required></div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0"><button type="submit" class="btn btn-custom-primary w-100">Simpan Perubahan</button></div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <?php if(empty($katalog)): ?>
                    <tr><td colspan="7" class="text-center py-4 text-secondary small">Belum ada material yang ditambahkan untuk supplier ini.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addMaterialModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 rounded-4">
            <form action="<?= base_url('supplier/store_material') ?>" method="POST">
                <input type="hidden" name="id_supplier" value="<?= $supplier['id_supplier'] ?>">
                <div class="modal-header"><h5 class="modal-title fw-bold" style="color:#4d1a11;">Tambah Material Baru</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label small fw-semibold">Nama Material</label><input type="text" name="nama_material" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label class="form-label small fw-semibold">Satuan (Misal: Pcs, Sak)</label><input type="text" name="satuan" class="form-control" required></div>
                        <div class="col-md-12 mb-3"><label class="form-label small fw-semibold">Spesifikasi</label><textarea name="spesifikasi" class="form-control" rows="2" placeholder="Opsional..."></textarea></div>
                        <hr class="my-3 opacity-25">
                        <div class="col-md-4 mb-3"><label class="form-label small fw-semibold">Harga Jual (Rp)</label><input type="number" name="harga" class="form-control" required></div>
                        <div class="col-md-4 mb-3"><label class="form-label small fw-semibold">Waktu Kirim (Hari)</label><input type="number" name="waktu_kirim" class="form-control" required></div>
                        <div class="col-md-4 mb-3"><label class="form-label small fw-semibold">Stok di Supplier</label><input type="number" name="stok_supplier" class="form-control" required></div>
                    </div>
                </div>
                <div class="modal-footer border-0"><button type="submit" class="btn btn-custom-primary w-100">Simpan Material</button></div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>