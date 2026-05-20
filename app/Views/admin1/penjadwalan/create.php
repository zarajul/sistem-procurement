<?= $this->extend('layout/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="<?= base_url('penjadwalan') ?>" class="text-decoration-none small text-secondary">← Kembali ke Daftar</a>
    <h5 class="fw-bold mt-2" style="color: #000000;">JADWALKAN PENGIRIMAN</h5>
    <p class="text-dark small">No. Referensi PO: <strong><?= esc($po['no_transaksi']) ?></strong></p>
</div>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger rounded-3 small py-2"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<form action="<?= base_url('penjadwalan/store') ?>" method="POST">
    <input type="hidden" name="id_transaksi" value="<?= esc($po['id_transaksi']) ?>">
    
    <div class="card card-custom p-4 border-0 mb-4 shadow-sm">
        <div class="row mb-4">
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Tanggal Estimasi Kirim</label>
                <input type="date" name="tanggal_kirim" class="form-control border-dark" value="<?= date('Y-m-d') ?>" required>
            </div>
        </div>

        <h6 class="small fw-semibold mb-3 border-bottom pb-2">Pilih Material yang Akan Dikirim</h6>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">Pilih</th>
                        <th width="35%">Nama Material</th>
                        <th width="20%" class="text-center">Sisa Belum Dikirim</th>
                        <th width="40%" class="text-center">Qty Kirim</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($detail as $d): ?>
                    <tr>
                        <td class="text-center">
                            <input class="form-check-input check-material" type="checkbox" name="dipilih[]" value="<?= $d['id_detail_transaksi'] ?>" style="transform: scale(1.3);">
                        </td>
                        <td>
                            <div class="fw-bold text-dark"><?= esc($d['nama_material']) ?></div>
                            <small class="text-muted d-block" style="font-size: 0.75rem;">
                                <i class="fa-solid fa-circle-info text-primary me-1"></i> 
                                <?= !empty($d['spesifikasi']) ? esc($d['spesifikasi']) : 'Tidak ada spesifikasi' ?>
                            </small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-dark text-white"><?= $d['qty_sisa'] ?> / <?= $d['qty'] ?></span> 
                            <small class="text-secondary"><?= esc($d['satuan']) ?></small>
                        </td>
                        <td class="text-center">
                            <div class="input-group input-group-sm d-flex justify-content-center" style="max-width: 170px; margin: 0 auto;">
                                <input type="number" name="qty_kirim[<?= $d['id_detail_transaksi'] ?>]" class="form-control input-qty" max="<?= $d['qty_sisa'] ?>" min="1" value="<?= $d['qty_sisa'] ?>" disabled required>
                                <span class="input-group-text small"><?= esc($d['satuan']) ?></span>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-custom-primary px-4 py-2 shadow-sm">
            <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Jadwal
        </button>
    </div>
</form>

<script>
    // Script Aktifkan/Nonaktifkan Input
    document.querySelectorAll('.check-material').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            let inputQty = this.closest('tr').querySelector('.input-qty');
            if (this.checked) {
                inputQty.disabled = false;
                inputQty.focus();
            } else {
                inputQty.disabled = true;
            }
        });
    });
</script>

<?= $this->endSection() ?>