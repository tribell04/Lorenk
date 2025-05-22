<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Data Pencairan</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    <?= form_open('admin/pencairan/edit/' . $pencairan->id); ?>
                    
                    <div class="form-group">
                        <label for="program_id">Program Donasi</label>
                        <select name="program_id" id="program_id" class="form-control" required>
                            <option value="">-- Pilih Program --</option>
                            <?php foreach ($programs as $program) : ?>
                                <option value="<?= $program->id_program; ?>" <?= ($program->id_program == $pencairan->program_id) ? 'selected' : ''; ?>>
                                <?= $program->judul; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('program_id', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="jumlah">Jumlah Pencairan (Rp)</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" value="<?= $pencairan->jumlah; ?>" required>
                        <?= form_error('jumlah', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal">Tanggal Pencairan</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d', strtotime($pencairan->tanggal)); ?>" required>
                        <?= form_error('tanggal', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="keterangan">Keterangan / Penggunaan Dana</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="4" required><?= $pencairan->keterangan; ?></textarea>
                        <?= form_error('keterangan', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="<?= site_url('admin/pencairan'); ?>" class="btn btn-secondary">Batal</a>
                    </div>
                    
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>