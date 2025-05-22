<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Riwayat Donasi</h1>

    <div class="card shadow mb-4">
        </div>
    

<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr class="text-center align-middle">
            <th>No</th>
            <th>Program</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($riwayat)) : ?>
            <?php $no = 1; foreach ($riwayat as $donasi) : ?>
            <tr class="text-center align-middle">
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($donasi->program_judul); ?></td>
                    <td>Rp <?= number_format($donasi->nominal, 0, ',', '.'); ?></td>
                    <td><?= date('d/m/Y', strtotime($donasi->tanggal)); ?></td>
                    <td>
                        <?php
                        $status = strtolower($donasi->status);
                        $warna = 'warning'; // default
                        if ($status === 'completed' || $status === 'selesai') {
                            $warna = 'success';
                        } else if ($status === 'verified') {
                            $warna = 'primary';
                        }
                    ?>
                    <span class="badge bg-<?= $warna; ?> text-white mb-1 d-block">
                        <?= ucfirst(htmlspecialchars($donasi->status)); ?>
                    </span>

                    </td>
                   
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="5" class="text-center">Belum ada riwayat donasi.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
