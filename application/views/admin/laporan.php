<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Laporan Penggalangan Dana</h1>

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
            <a href="<?= site_url('admin/pencairan'); ?>" class="btn btn-success mb-3">
                <i class="fas fa-money-check-alt"></i> Laporan Pencairan
            </a>
            <a href="<?= site_url('admin/cetakmsk?tahun=' . $selected_year); ?>" class="btn btn-info mb-3" target="_blank">
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


    <link rel="stylesheet" href="<?= base_url('assets/css/profile.css') ?>">
    <!-- Tabel Detail Transaksi -->
    <div class="card shadow mt-4" id="print-area">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Detail Pemasukan</h5>
        </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Program Donasi</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($laporan)) : ?>
                <?php 
                     $no = 1;
                     foreach ($laporan as $l) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $l->nama_donatur ?? 'Anonim'; ?></td>
                    <td><?= $l->judul_program; ?></td>
                    <td>Rp <?= number_format($l->nominal, 0, ',', '.'); ?></td>
                    <td><?= date('d/m/Y', strtotime($l->tanggal)); ?></td>
                    <td><span class="badge bg-success text-white"><?= ucfirst($l->status); ?></span></td>
                </tr>
                <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data donasi completed untuk tahun ini.</td>
                    </tr>
                <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>
