<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Kelola Donatur</h6>
            <a href="<?= base_url('admin/tambah_donatur'); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Donatur
            </a>
        </div>
        <div class="card-body">
            <!-- Search Bar -->
            <div class="mb-3">
                <input type="text" id="searchDonatur" class="form-control" placeholder="Cari Donatur">
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Id</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No Telpon</th>
                            <th>Status</th>
                            <th>Total Donasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($donatur) && is_array($donatur)) : ?>
                            <?php $no = 1; foreach ($donatur as $d) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= isset($d['name']) ? $d['name'] : 'Tidak ada data'; ?></td>
                                <td><?= isset($d['email']) ? $d['email'] : 'Tidak ada data'; ?></td>
                                <td><?= isset($d['telepon']) ? $d['telepon'] : 'Tidak ada data'; ?></td>
                                <td><span class="badge badge-success">Aktif</span></td>
                                <td>Rp <?= number_format($d['total_donasi'], 0, ',', '.'); ?></td>
                                <td>
                                    <a href="<?= base_url('admin/edit_donatur/' . $d['id']); ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-user-edit"></i>
                                    </a>
                                    <a href="<?= base_url('admin/delete_donatur/' . $d['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data donatur</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Script pencarian -->
<script>
document.getElementById('searchDonatur').addEventListener('keyup', function () {
    let input = this.value.toLowerCase();
    let rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
        let nama = row.cells[1].innerText.toLowerCase();
        if (nama.includes(input)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});
</script>
