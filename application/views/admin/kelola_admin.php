<!-- application/views/admin/kelola_admin.php -->
<div class="container mt-4">
    <h3 class="mb-4">Kelola Admin</h3>
    
    <?= $this->session->flashdata('pesan'); ?>

    <a href="<?= base_url('admin/tambah_admin') ?>" class="btn btn-primary mb-3">Tambah Admin</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($admin)): ?>
                    <?php $no = 1; foreach ($admin as $a): ?>
                        <tr class="align-middle text-center">
                            <td><?= $no++ ?></td>
                            <td class="text-start"><?= htmlspecialchars($a->name) ?></td>
                            <td><?= htmlspecialchars($a->email) ?></td>
                            <td>
                                <img src="<?= base_url('assets/img/profile/' . $a->image) ?>" alt="Foto Admin" width="50" class="img-thumbnail rounded-circle">
                            </td>
                            <td>
                                <!-- Tombol Edit bisa ditambahkan jika ada fiturnya -->
                                <!-- <a href="<?= base_url('admin/update_admin/' . $a->id) ?>" class="btn btn-sm btn-warning">Edit</a> -->
                                <a href="<?= base_url('admin/delete_admin/' . $a->id) ?>" onclick="return confirm('Yakin ingin menghapus admin ini?')" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Data admin tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>