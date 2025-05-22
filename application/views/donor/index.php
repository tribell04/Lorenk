<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Donasi Anda</h1>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Donasi Anda</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Metode Pembayaran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($donations)): ?>
                            <?php foreach ($donations as $donation): ?>
                                <tr>
                                    <td><?= date('d-m-Y H:i', strtotime($donation['date_given'])); ?></td>
                                    <td>Rp <?= number_format($donation['amount'], 0, ',', '.'); ?></td>
                                    <td><?= $donation['payment_method']; ?></td>
                                    <td>
                                        <span class="badge badge-<?= $donation['status'] == 'success' ? 'success' : ($donation['status'] == 'pending' ? 'warning' : 'danger'); ?>">
                                            <?= ucfirst($donation['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Anda belum melakukan donasi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>