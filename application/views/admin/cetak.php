<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pencairan Dana - Panti Asuhan Nadhief Senon</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin-bottom: 5px;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .title {
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
            font-weight: bold;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 50%;
        }
        .info td {
            padding: 5px;
            vertical-align: top;
        }
        .summary {
            margin: 20px 0;
            width: 100%;
        }
        .summary-box {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 20px;
            float: left;
            width: 30%;
            margin-right: 3%;
            text-align: center;
        }
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .detail-table th, .detail-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .detail-table th {
            background-color: #f2f2f2;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature-line {
            margin-top: 80px;
        }
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: right; margin-bottom: 20px;">
        <button onclick="window.print()">Cetak Laporan</button>
        <button onclick="window.close()">Tutup</button>
    </div>

    <div class="header">
        <h1>PANTI ASUHAN NADHIEF SENON</h1>
        <p>Jl. Contoh No. 123, Kota Contoh, 12345</p>
        <p>Telp: (021) 1234567 | Email: info@panadifsenon.org</p>
    </div>

    <div class="title">LAPORAN PENCAIRAN DANA TAHUN <?= $selected_year; ?></div>

    <div class="info">
        <table>
            <tr>
                <td width="150">Tanggal Cetak</td>
                <td>: <?= date('d/m/Y') ?></td>
            </tr>
            <tr>
                <td>Periode Laporan</td>
                <td>: Tahun <?= $selected_year; ?></td>
            </tr>
        </table>
    </div>

    <h3>Detail Pencairan Dana</h3>
    <table class="detail-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Program Donasi</th>
                <th width="15%">Jumlah</th>
                <th width="15%">Tanggal</th>
                <th width="40%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pencairan)) : ?>
                <?php 
                    $no = 1;
                    foreach ($pencairan as $p) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $p->judul_program ?></td>
                        <td>Rp <?= number_format($p->jumlah, 0, ',', '.') ?></td>
                        <td><?= date('d/m/Y', strtotime($p->tanggal)) ?></td>
                        <td><?= $p->keterangan ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2" style="text-align: right;"><strong>TOTAL</strong></td>
                    <td colspan="3"><strong>Rp <?= number_format($total_pencairan, 0, ',', '.') ?></strong></td>
                </tr>
            <?php else : ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data pencairan untuk tahun ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
     <div class="summary">
        <p><strong>Total Pemasukan:</strong> Rp<?= number_format($total_pemasukan, 0, ',', '.'); ?></p>
        <p><strong>Total Pencairan:</strong> Rp<?= number_format($total_pencairan, 0, ',', '.'); ?></p>
        <p><strong>Saldo Akhir:</strong> Rp<?= number_format($saldo_akhir, 0, ',', '.'); ?></p>
    </div>

    <div class="signature">
        <p>Purbalingga, <?= date('d F Y') ?></p>
        <p>Ketua Panti Asuhan Nadhief Senon</p>
        <p class="signature-line">____________________</p>
        <p>Dra.Hj. Rahmah Hartati</p>
    </div>
    
    <script>
        window.onload = function() {
            // Auto print when page loads (uncomment if needed)
            // window.print();
        }
    </script>
</body>
</html>