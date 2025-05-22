<!-- admin/tambah_pencairan.php -->
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Pencairan Dana</h6>
                </div>
                <div class="card-body">
                    <?= form_open('admin/tambahpencairan'); ?>
                    
                    <?php if (validation_errors()) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= validation_errors(); ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="program_id">Program Donasi</label>
                        <select name="program_id" id="program_id" class="form-control">
                            <option value="">-- Pilih Program --</option>
                            <?php foreach ($programdonasi as $program) : ?>
                                <option value="<?= $program->id_program; ?>"><?= $program->judul; ?> (Terkumpul: Rp <?= number_format($program->total_terkumpul, 0, ',', '.'); ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="jumlah">Jumlah Pencairan</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan jumlah pencairan">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal">Tanggal Pencairan</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal">
                    </div>
                    
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="4" placeholder="Masukkan keterangan pencairan dana"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= site_url('admin/pencairan'); ?>" class="btn btn-secondary">Batal</a>
                    
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Format nominal dengan pemisah ribuan
        $('#jumlah').on('input', function() {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
    });
</script>