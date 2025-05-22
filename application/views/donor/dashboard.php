<?php $this->load->view('templates/header', ['title' => 'Dashboard Donatur']); ?>

<h2>Dashboard Donatur</h2>

<div class="stats">
    <div class="stat-box">
        <h4>Total Donasi Anda</h4>
        <p>Rp <?php echo number_format($total_donasi_donatur, 0, ',', '.'); ?></p>
    </div>
    <div class="stat-box">
        <h4>Program Diikuti</h4>
        <p><?php echo $total_program_diikuti; ?> program</p>
    </div>
    <div class="stat-box">
        <h4>Donasi Terakhir</h4>
        <p>Rp <?php echo number_format($donasi_terakhir, 0, ',', '.'); ?></p>
    </div>
</div>

<h3>Program yang Anda Ikuti</h3>
<?php foreach ($program_diikuti as $program): ?>
<div class="program-box">
    <h4><?php echo $program->nama_program; ?></h4>
    <p>Target: Rp <?php echo number_format($program->target, 0, ',', '.'); ?></p>
    <p>Terkumpul: Rp <?php echo number_format($program->terkumpul, 0, ',', '.'); ?></p>
    <div class="progress-bar">
        <div class="progress" style="width: <?php echo ($program->terkumpul / $program->target) * 100; ?>%"></div>
    </div>
</div>
<?php endforeach; ?>

<h3>Riwayat Donasi Anda</h3>
<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Program</th>
            <th>Jumlah</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($riwayat_donasi as $donasi): ?>
        <tr>
            <td><?php echo $donasi->tanggal; ?></td>
            <td><?php echo $donasi->program; ?></td>
            <td>Rp <?php echo number_format($donasi->jumlah, 0, ',', '.'); ?></td>
            <td><?php echo $donasi->status; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php $this->load->view('templates/footer'); ?>
