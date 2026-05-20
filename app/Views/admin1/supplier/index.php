<?= $this->extend('layout/admin_layout') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0" style="color: #000000;">DAFTAR SUPPLIER</h4>
    <button class="btn btn-custom-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">+ Tambah Supplier</button>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success rounded-3 small py-2"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card card-custom p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nama Supplier</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($suppliers as $row): ?>
                <tr>
                    <td class="text-dark"><?= $row['id_supplier'] ?></td>
                    <td class="fw-bold text-dark">
                        <a href="<?= base_url('supplier/detail/'.$row['id_supplier']) ?>" class="text-decoration-none" style="color: #000000;">
                            <?= esc($row['nama_supplier']) ?> ↗
                        </a>
                    </td>
                    <td><?= esc($row['no_telp']) ?></td>
                    <td><small class="text-secondary"><?= esc($row['alamat']) ?></small></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editSup<?= $row['id_supplier'] ?>">Edit</button>
                        <a href="<?= base_url('supplier/delete/'.$row['id_supplier']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus supplier ini?')">Hapus</a>
                    </td>
                </tr>

                <div class="modal fade text-start" id="editSup<?= $row['id_supplier'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content border-0 rounded-4">
                            <form action="<?= base_url('supplier/update/'.$row['id_supplier']) ?>" method="POST">
                                <div class="modal-header"><h5 class="modal-title fw-bold">Edit Supplier</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                <div class="modal-body">
                                    <div class="mb-3"><label class="form-label small fw-semibold">Nama Supplier</label><input type="text" name="nama_supplier" class="form-control" value="<?= esc($row['nama_supplier']) ?>" required></div>
                                    <div class="mb-3"><label class="form-label small fw-semibold">No. Telepon</label><input type="text" name="no_telp" class="form-control" value="<?= esc($row['no_telp']) ?>" required></div>
                                    <div class="mb-3"><label class="form-label small fw-semibold">Alamat</label><textarea name="alamat" class="form-control" rows="2" required><?= esc($row['alamat']) ?></textarea></div>
                                </div>
                                <div class="modal-footer border-0"><button type="submit" class="btn btn-custom-primary w-100">Simpan Perubahan</button></div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addSupplierModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4">
            <form action="<?= base_url('supplier/store') ?>" method="POST">
                <div class="modal-header"><h5 class="modal-title fw-bold" style="color:#4d1a11;">Tambah Supplier</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label small fw-semibold">Nama Supplier</label><input type="text" name="nama_supplier" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label small fw-semibold">No. Telepon</label><input type="text" name="no_telp" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label small fw-semibold">Alamat</label><textarea name="alamat" class="form-control" rows="2" required></textarea></div>
                </div>
                <div class="modal-footer border-0"><button type="submit" class="btn btn-custom-primary w-100">Simpan Data</button></div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>