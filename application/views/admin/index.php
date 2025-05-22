
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="container-fluid">
    
    <!-- Ringkasan -->
    <h5 class="font-weight-bold">Ringkasan</h5>
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Donatur</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_donatur; ?> Orang</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Program Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_program; ?> Program</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-folder-open fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pemasukan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($total_pemasukan, 0, ',', '.'); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Pengeluaran</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($total_pencairan, 0, ',', '.'); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <h1 class="h4 mb-4 font-weight-bold">Dashboard Statistik</h1>
    <div class="row">
    <!-- Pertumbuhan Transaksi Donasi -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="font-weight-bold">Pertumbuhan Transaksi Donasi</h6>
                    <div style="height: 210px;">
                        <canvas id="donasiChart"></canvas> <!-- ID boleh tetap -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribusi Dana -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="font-weight-bold">Distribusi Dana Program</h6>
                    <div style="height: 210px;">
                        <canvas id="distribusiChart"></canvas>
                    </div>
                    <ul class="mt-3">
                        <li>Pendidikan</li>
                        <li>Kesehatan</li>
                        <li>Pangan</li>
                        <li>Infrastruktur</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Definisi base_url (wajib jika kamu pakai di JS eksternal) -->
<script>
    const base_url = "<?= base_url(); ?>";
</script>


<!-- JS Khusus untuk donatur chart -->
<script src="<?= base_url('assets/js/chart-donatur.js'); ?>"></script>
<script src="<?= base_url('assets/js/chart-distribusi.js'); ?>"></script>


