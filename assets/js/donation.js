$(document).ready(function () {

    // Saat memilih nominal yang sudah ditentukan
    $('.nominal-option').click(function () {
        // Hapus class active dari semua opsi
        $('.nominal-option').removeClass('active');

        // Tambahkan class active ke opsi yang dipilih
        $(this).addClass('active');

        // Ambil nilai nominal
        var nominal = $(this).data('nominal');

        // Set nilai ke input hidden
        $('#nominal_selected').val(nominal);

        // Set juga ke input custom (diformat)
        $('#nominal_custom').val(formatRupiah(nominal.toString()));

        // Update nominal di bagian metode pembayaran
        updateNominalDisplay(nominal);
    });

    // Saat input manual pada nominal custom
    $('#nominal_custom').on('input', function () {
        // Ambil hanya angka
        var rawValue = $(this).val().replace(/[^\d]/g, '');

        // Format dan tampilkan kembali
        $(this).val(formatRupiah(rawValue));

        // Reset pilihan tombol nominal
        $('.nominal-option').removeClass('active');

        // Set ke input hidden
        $('#nominal_selected').val(rawValue);

        // Update tampilan nominal transfer
        updateNominalDisplay(rawValue);
    });

    // Saat memilih metode pembayaran
    $('.payment-method').click(function () {
        // Reset semua metode
        $('.payment-method').removeClass('active');

        // Tandai aktif
        $(this).addClass('active');

        // Ambil data metode
        var methodId = $(this).data('method');
        var methodName = $(this).data('name');

        // Set input hidden
        $('#metode_pembayaran').val(methodId);

        // Tampilkan detil metode
        $('#payment-details').show();
        $('.payment-detail-section').hide();

        if (methodName === 'QRIS') {
            $('#qris-section').show();
        } else if (methodName === 'Transfer Bank') {
            $('#bank-section').show();
        }
    });

    // Custom file input label
    $('.custom-file-input').on('change', function () {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });

    // Validasi sebelum submit form
    $('#form-donasi').submit(function (e) {
        var nominal = $('#nominal_selected').val();
        var metode = $('#metode_pembayaran').val();
        var bukti = $('#buktiPembayaran').val();

        if (!nominal || nominal <= 0) {
            e.preventDefault();
            alert('Silakan pilih atau masukkan nominal donasi');
            return false;
        }

        if (!metode) {
            e.preventDefault();
            alert('Silakan pilih metode pembayaran');
            return false;
        }

        if (!bukti) {
            e.preventDefault();
            alert('Silakan upload bukti pembayaran');
            return false;
        }

        return true;
    });

    // Fungsi format angka ke Rupiah
    function formatRupiah(angka) {
        var reverse = angka.toString().split('').reverse().join('');
        var ribuan = reverse.match(/\d{1,3}/g);
        var hasil = ribuan.join('.').split('').reverse().join('');
        return hasil;
    }

    // Fungsi update tampilan nominal transfer
    function updateNominalDisplay(nominal) {
        var formatted = 'Rp ' + formatRupiah(nominal.toString());
        $('#qris-nominal').text(formatted);
        $('#bank-nominal').text(formatted);
    }


});
