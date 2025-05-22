<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih Atas Donasi Anda</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/css/terima.css') ?>">

</head>
<body>
    <div class="thank-you-container">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-info-circle mr-2"></i> <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
        
        <div class="card thank-you-card">
            <div class="card-header">
                <!-- Jika ada logo, bisa ditampilkan di sini -->
                <img src="<?= base_url('assets/img/favicon.png') ?>" alt="Logo" class="logo"> 
                
                <h1 class="thank-you-title">Terima Kasih Atas Donasi Anda!</h1>
                <p class="thank-you-subtitle">Kebaikan Anda Akan Membawa Perubahan</p>
            </div>
            
            <div class="card-body">
                <p class="thank-you-message">
                    Kami mengucapkan terima kasih yang sebesar-besarnya atas kebaikan dan kemurahan hati Anda. 
                    Donasi yang Anda berikan akan kami gunakan sebaik mungkin untuk mendukung program-program kami dan 
                    membantu mereka yang membutuhkan.
                </p>
                
                <div class="donation-details">
                    <div class="detail-row">
                        <span class="detail-label">No. Transaksi</span>
                        <span class="detail-value"><?= isset($donasi['id']) ? 'TRX'.$donasi['id']  : 'TRX'.time() ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tanggal</span>
                        <span class="detail-value"><?= isset($donasi['tanggal']) ? date('d F Y ', strtotime($donasi['tanggal'])) : '-' ?>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Program</span>
                        <span class="detail-value"><?= isset($donasi['judul']) ? $donasi['judul'] : 'Program Donasi' ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Nominal Donasi</span>
                        <span class="detail-value">Rp <?= isset($donasi['nominal']) ? number_format($donasi['nominal'], 0, ',', '.') : '0' ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Metode Pembayaran</span>
                        <span class="detail-value">
                            <?= isset($donasi['metodePembayaran']) && isset($metode[$donasi['metodePembayaran']]) 
                            ? $metode[$donasi['metodePembayaran']] 
                            : 'Transfer Bank' ?>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status</span>
                        <span class="status-pending">Menunggu Konfirmasi</span>
                        <!-- Gunakan kode di bawah ini jika status sukses -->
                        <!-- <span class="status-success">Berhasil</span> -->
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="<?= base_url('user/donasi') ?>" class="btn btn-kembali">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Program
                    </a>
                </div>
                
                <div class="transaction-id">
                    ID Transaksi: <?= isset($donasi['id']) ? 'TRX'.$donasi['id'] : 'TRX'.time() ?>
                </div>
                
                <div class="contact-section">
                    <p>
                        Jika Anda memiliki pertanyaan atau membutuhkan bantuan, silakan hubungi kami di
                        <a href="mailto:info@organisasi.org" class="contact-link">pantiasuhannadhief@gmail.com</a> 
                        atau telepon <a href="tel:+628123456789" class="contact-link">0896-7013-4241</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>