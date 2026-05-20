<?= $this->extend('layout/admin_layout') ?>
<?= $this->section('content') ?>
    <h4 class="fw-bold mb-1" style="color: #000000;">SELAMAT DATANG, <?= esc($nama) ?>!</h4>
    <p class="text-secondary mb-4">Anda masuk sebagai pengguna dengan hak akses <strong><?= strtoupper($role) ?></strong>.</p>
    
    <div class="card card-custom p-4">
        <h5>Sistem Procurement Aktif</h5>
        <p class="mb-0 text-secondary">Pilih menu di samping untuk mulai mengelola data sistem.</p>
    </div>
<?= $this->endSection() ?>