<div class="container my-5">
    <div class="card">
        <div class="row no-gutters">
            <div class="col-md-6">
                <img src="<?= base_url('uploads/program/' . $program['foto']); ?>" class="img-fluid" alt="<?= $program['judul']; ?>">
            </div>
            <div class="col-md-6 p-4">
                <h5 class="text-primary"><?= $program['judul']; ?></h5>
                <h4 class="text-success">Rp<?= number_format($program['targetDonasi'], 0, ',', '.'); ?></h4>
                <p>Terkumpul dari <strong>Rp<?= number_format($program['terkumpul'], 0, ',', '.'); ?></strong></p>

                <?php 
                    $persen = ($program['targetDonasi'] > 0) ? ($program['terkumpul'] / $program['targetDonasi']) * 100 : 0;
                    $persen = min($persen, 100);

                    $today = new DateTime();
                    $selesai = new DateTime($program['tanggal_selesai']);
                    $sisa = $today->diff($selesai)->format('%r%a');
                    $sisa = ($sisa < 0) ? 0 : $sisa;
                ?>

                <div class="progress mb-2" style="height: 8px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= $persen; ?>%;"></div>
                </div>
                <p><small><?= $sisa; ?> hari tersisa</small></p>

                <!-- Tambahkan deskripsi di sini -->
                <div class="mb-3">
                    <p><?= nl2br(htmlspecialchars($program['deskripsi'])); ?></p>
                </div>

                <div class="d-flex justify-content-between mb-3 text-center">
                    <div>
                        <i class="fa fa-heart text-danger"></i><br>
                        <small><?= number_format($program['jumlah_donasi'], 0, ',', '.'); ?> Donasi</small>
                    </div>
                    <div>
                        <i class="fa fa-wallet text-primary"></i><br>
                        <small><?= $program['jumlah_pencairan']; ?>x Pencairan</small>
                    </div>
                </div>

                <a href="<?= base_url('user/donation/' . $program['id_program']); ?>" class="btn btn-success">Donasi sekarang</a>
            </div>
        </div>
    </div>
</div>
