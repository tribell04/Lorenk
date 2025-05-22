<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Detail Pencairan Dana</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pencairan</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 30%">Program Donasi</th>
                            <td><?= $pencairan->judul_program; ?></td>
                        </tr>
                        <tr>
                            <th>Jumlah Pencairan</th>
                            <td>Rp <?= number_format($pencairan->jumlah, 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Pencairan</th>
                            <td><?= date('d F Y', strtotime($pencairan->tanggal)); ?></td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td><?= nl2br($pencairan->keterangan); ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Input</th>
                            <td><?= isset($pencairan->created_at) ? date('d F Y H:i', strtotime($pencairan->created_at)) : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Terakhir Diperbarui</th>
                            <td><?= isset($pencairan->updated_at) ? date('d F Y H:i', strtotime($pencairan->updated_at)) : '-'; ?></td>
                        </tr>
                    </table>
                    
                    <hr>
                    
                    <div class="mt-3">
                        <a href="<?= site_url('admin/pencairan'); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="<?= site_url('admin/pencairan/edit/' . $pencairan->id); ?>" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="<?= site_url('admin/pencairan/hapus/' . $pencairan->id); ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg