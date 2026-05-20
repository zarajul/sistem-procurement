<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Purchase Order - <?= $po['no_transaksi'] ?></title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #4d1a11; padding-bottom: 10px; }
        .header h1 { color: #4d1a11; margin: 0; font-size: 24px; text-transform: uppercase;}
        .header h3 { margin: 5px 0; font-weight: normal; color: #666; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { vertical-align: top; padding: 3px; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #999; padding: 8px; }
        .data-table th { background-color: #f4f4f4; text-align: center; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 50px; width: 100%; }
        .footer td { text-align: center; width: 50%; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PT Hakiki Inti Sejati</h1>
        <h3>PRE-FABRICATED SPECIALIST - For Building & Housing</h3>
        <p><i>EARTHQUAKE RESISTANCE AND ENVIRONMENTALLY FRIENDLY BUILDING</i></p>
    </div>

    <h2 class="text-center" style="text-decoration: underline;">PURCHASE ORDER</h2>

    <table class="info-table">
        <tr>
            <td width="15%"><b>To</b></td>
            <td width="35%">: <?= esc($supplier['nama_supplier']) ?><br> &nbsp; <?= esc($supplier['alamat']) ?><br> &nbsp; Telp: <?= esc($supplier['no_telp']) ?></td>
            <td width="15%"><b>No. PO</b></td>
            <td width="35%">: <?= $po['no_transaksi'] ?></td>
        </tr>
        <tr>
            <td><b>From</b></td>
            <td>: PT Hakiki Inti Sejati</td>
            <td><b>Tanggal</b></td>
            <td>: <?= date('d F Y', strtotime($po['tanggal_transaksi'])) ?></td>
        </tr>
    </table>

    <p>Dengan Hormat,<br>Bersama dengan ini kami mengajukan permintaan material untuk proyek PT. Hakiki Inti Sejati sesuai dengan rincian sebagai berikut:</p>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="40%">Uraian Material</th>
                <th width="10%">Qty</th>
                <th width="10%">Satuan</th>
                <th width="15%">Harga Satuan (Rp)</th>
                <th width="20%">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($detail as $d): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= esc($d['nama_material']) ?></td>
                <td class="text-center"><?= $d['qty'] ?></td>
                <td class="text-center"><?= esc($d['satuan']) ?></td>
                <td class="text-right"><?= number_format($d['harga'],0,',','.') ?></td>
                <td class="text-right"><?= number_format($d['subtotal'],0,',','.') ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="5" class="text-right"><b>GRAND TOTAL</b></td>
                <td class="text-right"><b>Rp <?= number_format($po['total'],0,',','.') ?></b></td>
            </tr>
        </tbody>
    </table>

    <table class="footer">
        <tr>
            <td>
                Disetujui Oleh,<br><br><br><br>
                <b>( <?= esc($po['nama_admin']) ?> )</b><br>
                Purchasing Dept.
            </td>
            <td>
                Dikonfirmasi Oleh,<br><br><br><br>
                <b>( Pihak Supplier )</b><br>
                <?= esc($supplier['nama_supplier']) ?>
            </td>
        </tr>
    </table>
</body>
</html>