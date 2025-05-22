<?php $this->load->view('templates/header', ['title' => 'Dashboard Admin']); ?>

<h2>Dashboard Admin</h2>

<div class="stats">
    <div class="stat-box">
        <h4>Total Donasi</h4>
        <p>Rp <?php echo number_format($total_donasi, 0, ',', '.'); ?></p>
    </div>
    <div class="stat-box">
        <h4>Total Donatur</h4>
        <p><?php echo $total_donatur; ?> orang</p>
    </div>
    <div class="stat-box">
        <h4>Program Aktif</h4>
        <p><?php echo $total_program; ?> program</p>
    </div>
    <div class="stat-box">
        <h4>Donasi Bulan Ini</h4>
        <p>Rp <?php echo number_format($donasi_bulan_ini, 0, ',', '.'); ?></p>
    </div>
</div>

<!-- Grafik Tren Donasi -->
<canvas id="donasiChart"></canvas>

<script>
    var ctx = document.getElementById('donasiChart').getContext('2d');
    var donasiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_column($donasi_bulanan, 'bulan')); ?>,
            datasets: [{
                label: 'Total Donasi',
                data: <?php echo json_encode(array_column($donasi_bulanan, 'total_donasi')); ?>,
                borderColor: 'blue',
                fill: false
            }]
        }
    });
</script>

<!-- Tabel Donasi Terbaru -->
<h3>Donasi Terbaru</h3>
<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Donatur</th>
            <th>Program</th>
            <th>Jumlah</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($donasi_terbaru as $donasi): ?>
        <tr>
            <td><?php echo $donasi->tanggal; ?></td>
            <td><?php echo $donasi->nama_donatur; ?></td>
            <td><?php echo $donasi->program; ?></td>
            <td>Rp <?php echo number_format($donasi->jumlah, 0, ',', '.'); ?></td>
            <td><?php echo $donasi->status; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php $this->load->view('templates/footer'); ?>
