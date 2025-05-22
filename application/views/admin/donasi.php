<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Kelola Donasi</h1>
    <?php if ($this->session->flashdata('message')) : ?>
    <?= $this->session->flashdata('message'); ?>
    <?php endif; ?>


    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Donasi</h6>
            <div>
                <select id="filterStatus" class="form-control form-control-sm">
                    <option value="">Semua Status</option>
                    <option value="Pending">Pending</option>
                    <option value="verified">Verified</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center align-middle">
                            <th>No</th>
                            <th>Donatur</th>
                            <th>Program Donasi</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center align-middle">
                        <?php 
                        $no = 1;
                        if (!empty($donasi)) :
                            foreach ($donasi as $d) : ?>
                                <tr class="donasi-row" data-status="<?= htmlspecialchars($d['status']); ?>">
                                    <td><?= $no++; ?></td>
                                    <td><?= !empty($d['nama_donatur']) ? htmlspecialchars($d['nama_donatur']) : 'Anonim'; ?></td>
                                    <td><?= htmlspecialchars($d['judul']); ?></td>
                                    <td>Rp <?= isset($d['nominal']) ? number_format($d['nominal'], 0, ',', '.') : '0'; ?></td>
                                    <td><?= isset($d['tanggal']) ? date('d-m-Y', strtotime($d['tanggal'])) : '-'; ?></td>
                                    <td>
                                    <!-- Badge Status -->
                                    <span class="badge bg-<?= ($d['status'] == 'completed') ? 'success' : (($d['status'] == 'verified') ? 'primary' : 'warning'); ?> text-white mb-1 d-block">
                                        <?= ucfirst(htmlspecialchars($d['status'])); ?>
                                    </span>

                                    
                                    </td>

                                    <td class="text-center align-middle">
                                        
                                        <!-- Tombol Lihat Bukti Transfer -->
                                        <a href="<?= base_url('uploads/' . $d['buktiPembayaran']); ?>" 
                                        class="btn btn-info btn-sm" target="_blank" title="Lihat Bukti Transfer">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <!-- Tombol hapus donasi -->
                                       <a href="<?= base_url('admin/hapus_donasi/' . $d['id']); ?>" 
                                        class="btn btn-danger btn-sm" title="Hapus Data" 
                                        onclick="return confirm('Yakin ingin menghapus data donasi ini?');">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <!-- Form Ubah Status -->
                                    <form method="post" action="<?= base_url('admin/update_status_donasi'); ?>">
                                        <input type="hidden" name="id" value="<?= $d['id']; ?>">
                                        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                            <option value="pending" <?= $d['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="verified" <?= $d['status'] == 'verified' ? 'selected' : ''; ?>>Verified</option>
                                            <option value="completed" <?= $d['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                        </select>
                                    </form>

                                    </td>
                                </tr>
                        <?php 
                            endforeach;
                        else :
                        ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data donasi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Filter status donasi
document.getElementById('filterStatus').addEventListener('change', function() {
    let selectedStatus = this.value;
    document.querySelectorAll('.donasi-row').forEach(row => {
        if (selectedStatus === '' || row.getAttribute('data-status') === selectedStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>