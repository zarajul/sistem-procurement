<?= $this->extend('layout/admin_layout') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <h4 class="fw-bold mb-0" style="color: #000000;">MANAJEMEN PENJADWALAN DISTRIBUSI</h4>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success rounded-3 small py-2"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card card-custom p-4 mb-4 border-0 shadow-sm" style="border-top: 4px solid #4d1a11 !important;">
    <h6 class="fw-bold mb-3 text-dark">Jadwal Pengiriman Aktif</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID Jadwal</th>
                    <th>No. PO</th>
                    <th>Supplier</th>
                    <th>Tanggal Kirim</th>
                    <th>Status</th>
                    <th class="text-center">Aksi Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($jadwal as $j): ?>
                <tr>
                    <td class="fw-bold text-brown"><?= $j['id_jadwal'] ?></td>
                    <td><small class="text-secondary"><?= $j['no_transaksi'] ?></small></td>
                    <td class="fw-bold text-dark"><?= esc($j['nama_supplier']) ?></td>
                    <td><?= date('d M Y', strtotime($j['tanggal_kirim'])) ?></td>
                    <td>
                        <?php 
                            // Konfigurasi Warna Status Logistik
                            $bg = 'bg-secondary';
                            if($j['status_kirim'] == 'dijadwalkan') $bg = 'bg-warning text-dark';
                            if($j['status_kirim'] == 'dikirim')     $bg = 'bg-primary text-white';
                            if($j['status_kirim'] == 'diterima')    $bg = 'bg-info text-dark';
                            if($j['status_kirim'] == 'selesai')     $bg = 'bg-success text-white';
                        ?>
                        <span class="badge <?= $bg ?> text-uppercase py-2 px-3 shadow-sm" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                            <?= $j['status_kirim'] ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <form action="<?= base_url('penjadwalan/update_status/'.$j['id_jadwal']) ?>" method="POST" class="d-inline">
                            <?php if($j['status_kirim'] == 'dijadwalkan'): ?>
                                <input type="hidden" name="status_kirim" value="dikirim">
                                <button type="submit" class="btn btn-sm btn-primary fw-bold px-3 shadow-sm" onclick="return confirm('Tandai barang ini sedang dalam perjalanan (Dikirim)?')">
                                    <i class="fa-solid fa-truck-fast me-1"></i> Kirim Barang
                                </button>
                                
                            <?php elseif($j['status_kirim'] == 'dikirim'): ?>
                                <input type="hidden" name="status_kirim" value="diterima">
                                <button type="submit" class="btn btn-sm btn-info fw-bold px-3 shadow-sm text-dark" onclick="return confirm('Tandai barang telah sampai (Diterima) di Gudang?')">
                                    <i class="fa-solid fa-box-open me-1"></i> Terima Barang
                                </button>
                                
                            <?php elseif($j['status_kirim'] == 'diterima'): ?>
                                <input type="hidden" name="status_kirim" value="selesai">
                                <button type="submit" class="btn btn-sm btn-success fw-bold px-3 shadow-sm" onclick="return confirm('Selesaikan seluruh proses administrasi jadwal ini?')">
                                    <i class="fa-solid fa-check-double me-1"></i> Selesaikan
                                </button>
                                
                            <?php elseif($j['status_kirim'] == 'selesai'): ?>
                                <span class="text-success small fw-bold"><i class="fa-solid fa-circle-check"></i> Tuntas</span>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card card-custom p-4 border-0 shadow-sm">
    <h6 class="fw-bold mb-3 text-dark">Tabel Purchase Order (Siap Dijadwalkan)</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No. PO</th>
                    <th>Tanggal PO</th>
                    <th>Supplier Penerima</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($transaksi as $t): ?>
                <tr>
                    <td class="text-dark fw-bold"><?= $t['no_transaksi'] ?></td>
                    <td><?= date('d M Y', strtotime($t['tanggal_transaksi'])) ?></td>
                    <td class="text-dark"><?= esc($t['nama_supplier']) ?></td>
                    <td class="text-center">
                        <a href="<?= base_url('penjadwalan/create/'.$t['id_transaksi']) ?>" class="btn btn-sm btn-custom-primary px-3 rounded-pill shadow-sm">
                            <i class="fa-solid fa-calendar-plus me-1"></i> Buat Jadwal
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($transaksi)): ?>
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted small">Semua material pada PO saat ini telah dijadwalkan.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>