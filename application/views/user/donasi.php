<div class="container my-5">
    <h2 class="text-center mb-4">Daftar Program Donasi</h2>

    <?php if (!empty($programdonasi)) : ?>
        <div class="row">
            <?php foreach ($programdonasi as $program) : ?>
                <?php 
                    // Hitung sisa hari
                    $today = new DateTime();
                    $tanggal_selesai = new DateTime($program['tanggal_selesai']);
                    $sisa_hari = $today->diff($tanggal_selesai)->format('%r%a');
                    $sisa_hari = ($sisa_hari < 0) ? 0 : $sisa_hari;

                    // Hitung persentase progress
                    $persentase = ($program['targetDonasi'] > 0) ? min(100, ($program['terkumpul'] / $program['targetDonasi']) * 100) : 0;
                ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm h-100 position-relative">
                        <!-- Link ke Form Donasi -->
                        <a href="<?= base_url('user/donasi_detail/' . $program['id_program']); ?>" class="stretched-link"></a>

                        <!-- Gambar Program -->
                        <img src="<?= base_url('uploads/program/' . (!empty($program['foto']) ? $program['foto'] : 'default.jpg')); ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($program['judul']); ?>">

                        <div class="card-body">
                            <!-- Judul Program -->
                            <h5 class="card-title fw-bold"><?= htmlspecialchars($program['judul']); ?></h5>

                            <!-- Progress Bar -->
                            <div class="progress mb-2" style="height: 6px; background-color: #d4e8f4;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: <?= $persentase; ?>%;"></div>
                            </div>

                            <!-- Baris Terkumpul dan Sisa Hari -->
                            <div class="d-flex justify-content-between small text-dark">
                                <div>
                                    <div class="fw-bold">Terkumpul</div>
                                    <div>Rp<?= number_format($program['terkumpul'], 0, ',', '.'); ?></div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold">Sisa hari</div>
                                    <div><?= $sisa_hari; ?></div>
                                </div>
                            </div>
                        </div>

                        </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="alert alert-danger text-center" role="alert">
            Belum ada program donasi yang tersedia.
        </div>
    <?php endif; ?>
</div>

<!-- Bootstrap Bundle -->
<script src="<?= base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>

