<div class="container">
    <h2>Formulir Donasi</h2>
    
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo site_url('donation/store'); ?>" method="post">
        <div class="form-group">
            <label for="amount">Jumlah Donasi (Rp)</label>
            <input type="number" class="form-control" name="amount" required>
        </div>

        <div class="form-group">
            <label for="payment_method">Metode Pembayaran</label>
            <select name="payment_method" class="form-control" required>
                <option value="transfer_bank">Transfer Bank</option>
                <option value="ewallet">E-Wallet</option>
                <option value="virtual_account">Virtual Account</option>
            </select>
        </div>

        <div class="form-group">
            <label for="notes">Catatan (Opsional)</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Donasi</button>
    </form>
</div>