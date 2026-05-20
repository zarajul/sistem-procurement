<?= $this->extend('layout/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <h3 class="fw-bold mb-0" style="color: #4d1a11;">Buat Purchase Order</h3>
    <p class="text-secondary small">Penerima: <strong><?= esc($supplier['nama_supplier']) ?></strong></p>
</div>

<form action="<?= base_url('pembelian/store') ?>" method="POST">
    <input type="hidden" name="id_supplier" value="<?= $supplier['id_supplier'] ?>">
    
    <div class="card card-custom p-4 border-0 mb-4">
        <h6 class="fw-bold mb-3 border-bottom pb-2">Daftar Material yang Dipesan</h6>
        
        <div id="dynamic-form-area">
            <div class="row align-items-end mb-3 item-row">
                <div class="col-md-7">
                    <label class="form-label small fw-semibold">Pilih Material dari Katalog</label>
                    <select name="id_penawaran[]" class="form-select" required>
                        <option value="">-- Pilih Material --</option>
                        <?php foreach($katalog as $k): ?>
                            <option value="<?= $k['id_penawaran'] ?>">
                                <?= esc($k['nama_material']) ?> (Harga: Rp <?= number_format($k['harga'],0,',','.') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Kuantitas (Qty)</label>
                    <input type="number" name="qty[]" class="form-control" min="1" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger w-100 btn-remove" disabled>Hapus</button>
                </div>
            </div>
        </div>

        <div class="mt-2">
            <button type="button" id="btn-add-row" class="btn btn-outline-secondary btn-sm">+ Tambah Material Lain</button>
        </div>
    </div>

    <button type="submit" class="btn btn-custom-primary btn-lg px-5 shadow-sm">Simpan & Terbitkan PO</button>
</form>

<script>
    // Script Sederhana untuk Menambah Baris Form Material
    document.getElementById('btn-add-row').addEventListener('click', function() {
        let area = document.getElementById('dynamic-form-area');
        let newRow = area.children[0].cloneNode(true); // Gandakan baris pertama
        
        // Reset isi inputan
        newRow.querySelector('select').value = "";
        newRow.querySelector('input').value = "";
        newRow.querySelector('.btn-remove').disabled = false; // Aktifkan tombol hapus
        
        area.appendChild(newRow);
    });

    // Delegasi Event untuk Tombol Hapus Baris
    document.getElementById('dynamic-form-area').addEventListener('click', function(e) {
        if(e.target.classList.contains('btn-remove')) {
            e.target.closest('.item-row').remove();
        }
    });
</script>
<?= $this->endSection() ?>