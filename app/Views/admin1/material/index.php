<?= $this->extend('layout/admin_layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0" style="color: #4d1a11;">Data Material</h3>
    <button class="btn btn-custom-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Material</button>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success rounded-3"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card card-custom p-4">
    <div class="table-responsive">
        <table class="table table-custom table-hover align-middle">
            <thead>
                <tr>
                    <th>ID Material</th>
                    <th>Nama Material</th>
                    <th>Spesifikasi</th>
                    <th>Satuan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($materials as $row): ?>
                <tr>
                    <td class="fw-bold"><?= $row['id_material'] ?></td>
                    <td><?= esc($row['nama_material']) ?></td>
                    <td><?= esc($row['spesifikasi']) ?></td>
                    <td><span class="badge bg-secondary"><?= esc($row['satuan']) ?></span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_material'] ?>">Edit</button>
                        <a href="<?= base_url('material/delete/'.$row['id_material']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                    </td>
                </tr>

                <div class="modal fade" id="editModal<?= $row['id_material'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content border-0 rounded-4">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" style="color:#4d1a11;">Edit Material</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="<?= base_url('material/update/'.$row['id_material']) ?>" method="POST">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Nama Material</label>
                                        <input type="text" name="nama_material" class="form-control" value="<?= esc($row['nama_material']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Spesifikasi</label>
                                        <textarea name="spesifikasi" class="form-control" rows="2"><?= esc($row['spesifikasi']) ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Satuan (Misal: Pcs, Kg, Sak)</label>
                                        <input type="text" name="satuan" class="form-control" value="<?= esc($row['satuan']) ?>" required>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="submit" class="btn btn-custom-primary w-100">Simpan Perubahan</button>
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

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="color:#4d1a11;">Tambah Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('material/store') ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Material</label>
                        <input type="text" name="nama_material" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Spesifikasi</label>
                        <textarea name="spesifikasi" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Satuan</label>
                        <input type="text" name="satuan" class="form-control" placeholder="Contoh: Pcs, Kg, Sak" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-custom-primary w-100">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>