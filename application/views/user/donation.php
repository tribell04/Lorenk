<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Donasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/donation.css') ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url('assets/js/donation.js') ?>"></script>
</head>
<body>
<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-body">
            <h3 class="card-title text-center mb-4">Form Donasi</h3>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('user/donasi_action') ?>" method="post" enctype="multipart/form-data" id="form-donasi">
                <input type="hidden" name="program_id" value="<?= isset($program_id) ? $program_id : '' ?>">

                <div class="mb-4">
                    <h5 class="mb-3">Donasi untuk Program <strong><?= $program->judul ?></strong></h5>
                    <label class="font-weight-bold">Pilih Nominal</label>
                    <div class="row">
                        <?php foreach ([50000, 100000, 200000, 250000, 500000, 1000000] as $nominal): ?>
                            <div class="col-md-4 mb-3">
                                <div class="nominal-option" data-nominal="<?= $nominal ?>">
                                    Rp <?= number_format($nominal, 0, ',', '.') ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <label for="nominal_custom">Atau masukkan nominal lain</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" class="form-control" id="nominal_custom" name="nominal_custom" placeholder="Masukkan nominal">
                    </div>
                    <input type="hidden" name="nominal" id="nominal_selected">
                </div>

                <div class="mb-4">
                    <label class="font-weight-bold">Metode Pembayaran</label>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="payment-method" data-method="1" data-name="QRIS">
                                <i class="fas fa-qrcode"></i> QRIS
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="payment-method" data-method="2" data-name="Transfer Bank">
                                <i class="fas fa-university"></i> Transfer Bank
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="metodePembayaran" id="metode_pembayaran">
                </div>

                <div id="payment-details" style="display: none;">
                    <div id="qris-section" class="payment-detail-section text-center" style="display: none;">
                        <h5>Pembayaran QRIS</h5>
                        <img src="<?= base_url('assets/gambar/qris.jpeg') ?>" class="img-fluid mb-3" alt="QR Code">
                        <p>Scan QR Code menggunakan aplikasi e-wallet Anda</p>
                        <p class="font-weight-bold">Nominal Transfer: <span id="qris-nominal">Rp 0</span></p>
                    </div>
                    <div id="bank-section" class="payment-detail-section text-center" style="display: none;">
                        <h5>Transfer Bank</h5>
                        <p><strong>Bank Jateng</strong></p>
                        <p>No. Rek: 3027 3227 69</p>
                        <p>a.n. Panti Asuhan Nadhief Senon</p>
                        <p class="font-weight-bold">Nominal Transfer: <span id="bank-nominal">Rp 0</span></p>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="font-weight-bold">Upload Bukti Pembayaran</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="buktiPembayaran" name="buktiPembayaran" accept=".jpg,.jpeg,.png" required>
                        <label class="custom-file-label" for="buktiPembayaran">Pilih file</label>
                    </div>
                    <small class="form-text text-muted">Format: JPG/PNG, Maks: 5MB</small>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg">Konfirmasi Donasi</button>
            </form>
        </div>
    </div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
