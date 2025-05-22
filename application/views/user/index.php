<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="card mb-3" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="card-img">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= $user['name']; ?></h5>
                    <p class="card-text"><?= $user['email']; ?></p>
                    <p class="card-text"><small class="text-muted">Member sejak <?= date('d F Y', $user['date_created']); ?></small></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Akun -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Akun</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <tr>
                                <th>Nama Lengkap</th>
                                <td><?= $user['name']; ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= $user['email']; ?></td>
                            </tr>
                            <tr>
                                <th>Status Akun</th>
                                <td>
                                    <?php if ($user['is_active'] == 1) : ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Tidak Aktif</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="mt-3">
                        <a href="<?= base_url('user/edit_profile'); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-user-edit"></i> Edit Profile
                        </a>
                        <a href="<?= base_url('user/change_password'); ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-key"></i> Ganti Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Cepat -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Menu Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <a href="<?= base_url('donasi/tambah'); ?>" class="card bg-primary text-white shadow">
                                <div class="card-body">
                                    <div class="text-center">
                                        <i class="fas fa-donate fa-3x mb-3"></i>
                                        <h5>Donasi Baru</h5>
                                        <p class="mb-0">Klik untuk membuat donasi baru</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 mb-4">
                            <a href="<?= base_url('donasi/riwayat'); ?>" class="card bg-success text-white shadow">
                                <div class="card-body">
                                    <div class="text-center">
                                        <i class="fas fa-history fa-3x mb-3"></i>
                                        <h5>Riwayat Donasi</h5>
                                        <p class="mb-0">Lihat riwayat donasi Anda</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->