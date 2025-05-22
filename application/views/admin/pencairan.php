<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Laporan Pencairan Dana</h1>

    <?= $this->session->flashdata('message'); ?>

    <!-- Filter Periode -->
    <div class="row mb-4">
        <div class="col-md-4">
            <form action="<?= site_url('admin/pencairan'); ?>" method="get" id="form-filter">
                <label for="tahun">Periode Tahun</label>
                <select id="tahun" name="tahun" class="form-control" onchange="document.getElementById('form-filter').submit()">
                    <?php foreach ($years as $year) : ?>
                        <option value="<?= $year->year; ?>" <?= ($selected_year == $year->year) ? 'selected' : ''; ?>><?= $year->year; ?></option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        <div class="col-md-8 text-right">
            <a href="<?= site_url('admin/tambahpencairan'); ?>" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Tambah Pencairan
            </a>
            <a href="<?= site_url('admin/laporan'); ?>" class="btn btn-success mb-3">
                <i class="fas fa-hand-holding-usd"></i> Laporan Donasi
            </a>
            <a href="<?= site_url('admin/cetak?tahun=' . $selected_year); ?>" class="btn btn-info mb-3" target="_blank">
                <i class="fas fa-print"></i> Cetak Laporan
            </a>
        </div>
    </div>

    <!-- Kartu Ringkasan -->
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow border-left-primary">
                <div class="card-body text-center">
                    <h5>Total Donasi</h5>
                    <h4>Rp <?= number_format($total_pemasukan, 0, ',', '.'); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow border-left-danger">
                <div class="card-body text-center">
                    <h5>Total Pencairan</h5>
                    <h4>Rp <?= number_format($total_pencairan, 0, ',', '.'); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow border-left-success">
                <div class="card-body text-center">
                    <h5>Saldo Akhir</h5>
                    <h4>Rp <?= number_format($saldo_akhir, 0, ',', '.'); ?></h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Detail Pencairan -->
    <div class="card shadow mt-4">
        <div class="card-body">
            <h5 class="mb-3">Detail Pencairan Dana</h5>
            <div class="table-responsive">
                <table class="table table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Program Donasi</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pencairan)) : ?>
                            <?php 
                                $no = 1;
                                foreach ($pencairan as $p) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $p->judul_program; ?></td>
                                    <td>Rp <?= number_format($p->jumlah, 0, ',', '.'); ?></td>
                                    <td><?= date('d/m/Y', strtotime($p->tanggal)); ?></td>
                                    <td><?= substr($p->keterangan, 0, 50); ?><?= (strlen($p->keterangan) > 50) ? '...' : ''; ?></td>
                                    <td>
                                        <a href="<?= site_url('admin/detail/' . $p->id); ?>" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= site_url('admin/edit/' . $p->id); ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= site_url('admin/hapus/' . $p->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data pencairan untuk tahun ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script>