<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Kelola Program Donasi</h2>

    <!-- Flash Message -->
    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('message'); ?>
        </div>
    <?php endif; ?>

    <!-- Tombol Tambah Program -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#programModal">Tambah Program</button>

    <!-- Tabel Program -->
    <?php if (!empty($program)) : ?>
        <table class="table table-bordered text-center align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Judul Program</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Target Donasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($program as $p) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>
                        <?php
                        $gambar = (!empty($p->foto)) 
                            ? base_url('uploads/program/' . $p->foto) 
                            : base_url('assets/img/default/noimage.png');
                        ?>
                        <img src="<?= $gambar; ?>" alt="Gambar Program" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">

                    </td>
                    <td><?= htmlspecialchars($p->judul); ?></td>
                    <td>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalDeskripsi<?= $p->id_program; ?>">
                            Lihat
                        </button>
                    </td>
                    <td><?= date('d M Y', strtotime($p->tanggal_mulai)); ?></td>
                    <td><?= date('d M Y', strtotime($p->tanggal_selesai)); ?></td>
                    <td>Rp <?= number_format($p->targetDonasi, 0, ',', '.'); ?></td>
                    
                    <td>
                        <?php if ($p->is_completed): ?>

                            <span class="badge bg-success">Selesai</span>
                        <?php else: ?>
                            <span class="badge bg-warning">Berjalan</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="<?= site_url('admin/edit_program/' . $p->id_program); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?= site_url('admin/hapus_program/' . $p->id_program); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus program ini?')">Hapus</a>
                    </td>
                </tr>

                <!-- Modal Deskripsi -->
                <div class="modal fade" id="modalDeskripsi<?= $p->id_program; ?>" tabindex="-1" aria-labelledby="modalLabel<?= $p->id_program; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel<?= $p->id_program; ?>">Deskripsi Lengkap</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?= nl2br(htmlspecialchars($p->deskripsi)); ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p class="text-center">Belum ada program donasi.</p>
    <?php endif; ?>
</div>

<!-- Modal Tambah Program -->
<div class="modal fade" id="programModal" tabindex="-1" aria-labelledby="programModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="programModalLabel">Tambah Program Donasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="<?= base_url('admin/tambah_program'); ?>" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="mb-3">
            <label for="judul" class="form-label">Judul Program</label>
            <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul program" required>
          </div>

          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukkan deskripsi program" required></textarea>
          </div>

          <div class="mb-3">
            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
          </div>

          <div class="mb-3">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
          </div>

          <div class="mb-3">
            <label for="targetDonasi" class="form-label">Target Donasi (Rp)</label>
            <input type="number" class="form-control" id="targetDonasi" name="targetDonasi" placeholder="Masukkan target donasi" required>
          </div>

          <div class="mb-3">
            <label for="foto" class="form-label">Upload Gambar Program</label>
            <input type="file" class="form-control" id="foto" name="foto">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan Program</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
