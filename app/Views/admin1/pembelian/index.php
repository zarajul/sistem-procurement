<?= $this->extend('layout/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <h4 class="fw-bold mb-0" style="color: #000000;">RIWAYAT PEMBELIAN</h4>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success rounded-3 small py-2"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card card-custom p-4 border-0 shadow-sm">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>No. PO</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>Total Nilai (Rp)</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                // Array penamaan bulan bahasa Indonesia
                $bulanIndo = [
                    1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
            ?>
            
            <?php foreach($transaksi as $t): ?>
            <tr>
                <td class="text-dark fw-semibold"><?= $t['no_transaksi'] ?></td>
                <td>
                    <?php 
                        // Memformat tanggal ke bahasa Indonesia
                        $waktu = strtotime($t['tanggal_transaksi']);
                        $tanggal = date('d', $waktu);
                        $bulan = $bulanIndo[(int)date('m', $waktu)];
                        $tahun = date('Y', $waktu);
                        echo "$tanggal $bulan $tahun"; 
                    ?>
                </td>
                <td class="text-dark"><?= esc($t['nama_supplier']) ?></td>
                <td>Rp <?= number_format($t['total'],0,',','.') ?></td>
                <td class="text-center">
                    <a href="<?= base_url('pembelian/cetak_pdf/'.$t['id_transaksi']) ?>" target="_blank" class="btn btn-sm btn-outline-success">
                        <i class="fa-solid"></i> Cetak PDF
                    </a>
                    <a href="<?= base_url('pembelian/delete/'.$t['id_transaksi']) ?>" class="btn btn-sm btn-outline-danger ms-1" onclick="return confirm('Apakah Anda yakin ingin menghapus PO ini? Seluruh data material di dalamnya juga akan terhapus.')">
                        <i class="fa-solid"></i> Hapus
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            
            <?php if(empty($transaksi)): ?>
                <tr><td colspan="5" class="text-center py-4 text-secondary small">Belum ada riwayat Purchase Order.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>