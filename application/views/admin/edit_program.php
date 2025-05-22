<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Program Donasi</h2>

    <!-- Tampilkan pesan jika ada notifikasi -->
    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('message'); ?>
        </div>
    <?php endif; ?>

    <!-- Form Edit Program -->
    <?= form_open_multipart('admin/update_program/' . $program->id_program); ?>

     <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
    
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Program</label>
            <input type="text" name="judul" id="judul" class="form-control" value="<?= htmlspecialchars($program->judul); ?>" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" required><?= htmlspecialchars($program->deskripsi); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="<?= $program->tanggal_mulai; ?>" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="<?= $program->tanggal_selesai; ?>" required>
        </div>

        <div class="mb-3">
            <label for="targetDonasi" class="form-label">Target Donasi (Rp)</label>
            <input type="number" name="targetDonasi" id="targetDonasi" class="form-control" value="<?= $program->targetDonasi; ?>" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="active" <?= ($program->status == 'active') ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?= ($program->status == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>

       <div class="mb-3">
            <label class="form-label">Gambar Saat Ini</label><br>
            <?php if (!empty($program->foto)): ?>
            <img src="<?= base_url('uploads/program/' . $program->foto); ?>" alt="Gambar Program" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
            <?php else: ?>
                <p>No image uploaded.</p>
            <?php endif; ?>
        </div>
        

        <div class="mb-3">
            <label for="foto" class="form-label">Ganti Gambar (Opsional)</label>
            <input type="file" name="foto" id="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="<?= site_url('admin/program'); ?>" class="btn btn-secondary">Batal</a>
        </div>    
    </div>    

    <?= form_close(); ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
