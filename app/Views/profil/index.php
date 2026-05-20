<?= $this->extend('layout/admin_layout') ?>
<?= $this->section('content') ?>

<style>
    .card-custom .form-control {
        font-size: 0.9rem;
        padding: 10px 15px;
    }
    .card-custom .form-control::placeholder {
        font-size: 0.9rem;
        color: #94a3b8;
    }
</style>

<div class="mb-4">
    <h4 class="fw-bold mb-0" style="color: #000000;">Kelola Profil Anda</h4>
    <p class="text-secondary small">Perbarui username, nama, email, dan password Anda.</p>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success rounded-3 small py-2"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger rounded-3 small py-2"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8">
        <div class="card card-custom p-4 border-0 shadow-sm">
            <form action="<?= base_url('profil/update') ?>" method="POST">
                
                <h6 class="fw-bold mb-3 text-dark border-bottom pb-2">Informasi Akun</h6>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Username</label>
                    <input type="text" name="username" class="form-control text-dark" value="<?= esc($user['username']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="<?= esc($user['nama']) ?>" required>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold">Alamat Email</label>
                    <input type="email" name="email" class="form-control" value="<?= esc($user['email']) ?>">
                </div>

                <h6 class="fw-bold mb-3 text-dark border-bottom pb-2 mt-4">Ubah Password</h6>
                <p class="small text-muted mb-3">Biarkan kolom kosong jika Anda tidak ingin mengubah password.</p>
                
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Password Lama</label>
                    <input type="password" name="password_lama" class="form-control bg-light" placeholder="Masukkan password Anda saat ini">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold">Password Baru</label>
                        <input type="password" name="password_baru" class="form-control bg-light" placeholder="Masukkan password baru">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold">Konfirmasi Password Baru</label>
                        <input type="password" name="konfirmasi_password" class="form-control bg-light" placeholder="Ulangi password baru">
                    </div>
                </div>

                <hr class="opacity-25 mt-3 mb-4">

                <div class="text-end">
                    <button type="submit" class="btn btn-custom-primary px-4 py-2">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>