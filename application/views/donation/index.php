<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= isset($title) ? $title : 'Kelola Donasi'; ?></h1>

    <?= $this->session->flashdata('message'); ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Donasi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Donatur</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Bukti Transfer</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($donasi)) : ?>
                            <?php $i = 1; ?>
                            <?php foreach ($donasi as $d) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= date('d-m-Y H:i', strtotime($d['tanggal'])); ?></td>
                                    <td><?= $d['nama_donatur']; ?></td>
                                    <td>Rp <?= number_format($d['nominal'], 0, ',', '.'); ?></td>
                                    <td><?= $d['keterangan']; ?></td>
                                    <td>
                                        <a href="<?= base_url('assets/img/bukti_transfer/' . $d['bukti_transfer']); ?>" target="_blank">
                                            <img src="<?= base_url('assets/img/bukti_transfer/' . $d['bukti_transfer']); ?>" alt="Bukti Transfer" class="img-thumbnail" style="max-width: 100px;">
                                        </a>
                                    </td>
                                    <td>
                                        <?php if ($d['status'] == 'pending') : ?>
                                            <span class="badge badge-warning">Pending</span>
                                        <?php elseif ($d['status'] == 'approved') : ?>
                                            <span class="badge badge-success">Approved</span>
                                        <?php else : ?>
                                            <span class="badge badge-danger">Rejected</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($d['status'] == 'pending') : ?>
                                            <a href="<?= base_url('admin/approve_donation/' . $d['id']); ?>" class="btn btn-success btn-sm" onclick="return confirm('Apakah Anda yakin ingin menyetujui donasi ini?');">Approve</a>
                                            <a href="<?= base_url('admin/reject_donation/' . $d['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menolak donasi ini?');">Reject</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data donasi</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->