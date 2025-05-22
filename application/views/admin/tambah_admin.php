<!-- application/views/admin/tambah_admin.php -->
<div class="container mt-4">
    <h3 class="mb-4">Tambah Admin</h3>

    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

    <form action="<?= base_url('admin/simpan_admin') ?>" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= set_value('name') ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= set_value('email') ?>" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <!-- Jika ingin menambahkan upload foto di masa depan:
        <div class="mb-3">
            <label for="image" class="form-label">Foto (opsional)</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        -->

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="<?= base_url('admin/kelola_admin') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>