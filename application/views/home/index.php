<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panti Asuhan Nadhief</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,700;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/donasi.css'); ?>">

    <!-- Icon -->
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>">

    <!-- My Style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <script src="<?php echo base_url('assets/js/script.js'); ?>"></script>

    <!-- FatherIcon -->
    <script src="https://unpkg.com/feather-icons"></script>

</head>
<body>
    <!-- Navbar Start-->
   <!-- Navbar -->
<nav class="navbar">
        <a href="#" class="navbar-logo">sahabat<span>Panti</span>.</a>

        <div class="navbar-nav">
            <a href="#home">Home</a>
            <a href="#about">Tentang Kami</a>
            <a href="#donasi">Cara Berdonasi</a>
            <a href="#gallery">Gallery</a>
            <a href="#contact">Kontak</a>
            <a href="<?php echo site_url('auth/index'); ?>">Login</a>
        </div>

        <div class="navbar-extra">
            <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
        </div>

    </nav>
    <!-- Navbar end-->
    
    <!-- Hero Section Start -->
    <section class="hero" id="home">
        <main class="content">
           <h1>Berbagi <span>Harapan</span> Bersama Kami</h1>
            <p>Membantu anak-anak yatim dan dhuafa meraih masa depan yang lebih baik</p>
            <a href="<?php echo site_url('auth/index'); ?>" class="cta">Donasi Sekarang</a>
        </main>
    </section>


    <!-- Hero Section End -->

    <!-- About Section Start -->
    <section id="about" class="about">
        <h2><span>Tentang</span> Kami</h2>
        <div class="row">
            <div class="about-img">
                <img src="<?= base_url('assets/img/panti.jpeg') ?>" alt="Tentang Kami" loading="lazy">
            </div> 
        <div class="content">
            <p>Panti Asuhan Nadhief Senon adalah Lembaga Kesejahteraan Sosial Anak (LKSA) yang berdiri secara mandiri di Desa Senon, Purbalingga. Kami berkomitmen memberikan perlindungan, pengasuhan, pendidikan, dan pembinaan bagi anak-anak yatim, piatu, yatim piatu, serta anak terlantar agar mereka tumbuh dengan kasih sayang, pendidikan yang layak, dan masa depan yang lebih baik.
                Sejak awal berdirinya hingga kini, kami terus berkembang melalui dukungan masyarakat, donatur, dan berbagai yayasan yang pernah bermitra, dengan tujuan utama membentuk generasi mandiri, berakhlak, dan berdaya saing.
            </p>
            <a href="<?php echo site_url('home/visi_misi'); ?>" class="cta">Profil</a>

        </div>
        </div>
    </section>
    <!-- About Section End -->

   <!-- Donasi Section Start -->
<section id="donasi" class="donasi">
  <div class="container">
    <!-- Section Header -->
    <div class="section-header">
      <h2><span>Cara</span> Berdonasi</h2>
      <p>Ikuti langkah-langkah sederhana berikut untuk memberikan donasi dan membantu kami mewujudkan perubahan nyata.</p>
    </div>

    <div class="donasi-container">
      <div class="donasi-card">
        <!-- Left Side - Image -->
        <div class="donasi-img">
          <img src="<?= base_url('assets/img/panti.jpeg') ?>" alt="Cara Berdonasi" loading="lazy">
        </div>
        
        <!-- Right Side - Content -->
        <div class="donasi-content">
          <div class="donasi-steps">
            <!-- Step 1 -->
            <div class="donasi-step">
              <div class="step-number">1</div>
              <div class="step-content">
                <h3>Login ke Akun Anda</h3>
                <p>Masuk ke akun Anda untuk melihat program donasi yang tersedia.</p>
              </div>
            </div>
            
            <!-- Step 1 -->
            <div class="donasi-step">
              <div class="step-number">2</div>
              <div class="step-content">
                <h3>Lihat Program Donasi</h3>
                <p>Telusuri daftar program donasi yang tersedia dan pilih yang ingin Anda dukung.</p>
              </div>
            </div>

            <!-- Step 2 -->
            <div class="donasi-step">
              <div class="step-number">3</div>
              <div class="step-content">
                <h3>Pilih Nominal Donasi</h3>
                <p>Pilih nominal yang sudah tersedia atau masukkan jumlah sesuai keinginan Anda.</p>
              </div>
            </div>
            
            <!-- Step 3 -->
            <div class="donasi-step">
              <div class="step-number">4</div>
              <div class="step-content">
                <h3>Pilih Metode Pembayaran</h3>
                <p>Pilih metode pembayaran yang tersedia (QRIS atau Transfer Bank).</p>
              </div>
            </div>
            
            <!-- Step 4 -->
            <div class="donasi-step">
              <div class="step-number">5</div>
              <div class="step-content">
                <h3>Upload Bukti Pembayaran</h3>
                <p>Upload bukti transfer jika diminta untuk verifikasi donasi Anda.</p>
              </div>
            </div>
            
            <!-- Step 5 -->
            <div class="donasi-step">
              <div class="step-number">6</div>
              <div class="step-content">
                <h3>Kirim Donasi</h3>
                <p>Klik tombol "Donasi Sekarang" untuk menyelesaikan proses.</p>
              </div>
            </div>
          </div>
          
          <div class="donasi-cta">
            <a href="<?= site_url('auth/index') ?>" class="cta-button">Donasi Sekarang</a>
          </div>
        </div>
      </div>
      
      <!-- Trust Badges -->
      <div class="trust-badges">
        <div class="trust-badge">
          <div class="trust-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
          </div>
          <h3>100% Aman</h3>
          <p>Transaksi donasi dijamin aman</p>
        </div>
        <div class="trust-badge">
          <div class="trust-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </div>
          <h3>Pembayaran Mudah</h3>
          <p>Berbagai metode pembayaran</p>
        </div>
        <div class="trust-badge">
          <div class="trust-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
          </div>
          <h3>Transparansi</h3>
          <p>Laporan penggunaan dana</p>
        </div>
        <div class="trust-badge">
          <div class="trust-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h3>Proses Cepat</h3>
          <p>Verifikasi donasi instan</p>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Donasi Section End -->



   <!-- Gallery Section Start -->
<section id="gallery" class="gallery">
    <h2><span>Galeri</span> Panti</h2>
    <p>Potret kegiatan, fasilitas, dan kebersamaan anak-anak di Panti Asuhan Nadhief.</p>

    <div class="gallery-container">
        <div class="gallery-item">
            <img src="<?= base_url('assets/img/image2.jpeg') ?>" alt="Kegiatan Belajar" class="gallery-img">
        </div>
        <div class="gallery-item">
            <img src="<?= base_url('assets/img/image3.jpeg') ?>" alt="Kegiatan Bermain" class="gallery-img">
        </div>
        <div class="gallery-item">
            <img src="<?= base_url('assets/img/image12.jpeg') ?>" alt="Fasilitas Panti" class="gallery-img">
        </div>
        <div class="gallery-item">
            <img src="<?= base_url('assets/img/image11.jpeg') ?>" alt="Kegiatan Keagamaan" class="gallery-img">
        </div>
        <div class="gallery-item">
            <img src="<?= base_url('assets/img/image22.jpeg') ?>" alt="Event Sosial" class="gallery-img">
        </div>
        <div class="gallery-item">
            <img src="<?= base_url('assets/img/image221.jpeg') ?>" alt="Gotong Royong" class="gallery-img">
        </div>
         <div class="gallery-item">
            <img src="<?= base_url('assets/img/image1.jpeg') ?>" alt="Fasilitas Panti" class="gallery-img">
        </div>
        <div class="gallery-item">
            <img src="<?= base_url('assets/img/image2.jpeg') ?>" alt="Kegiatan Keagamaan" class="gallery-img">
        
    </div>
    
</section>
<!-- Gallery Section End -->

<!-- Contact Section Start -->
<section id="contact" class="contact">
    <h2><span>Komen</span> Donatur</h2>
    <p>Silahkan tinggalkan pesan untuk kami</p>

    <div class="row">
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.977194307484!2d109.3627741742517!3d-7.467769773615591!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e655b22dc6e6f45%3A0xe05664d308601706!2sLKSA%2FPanti%20Asuhan%20Nadhief%20Senon!5e0!3m2!1sid!2sid!4v1741184806829!5m2!1sid!2sid"
                width="100%" height="100%" style="border:0;" 
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <div class="content-komentar">
    <div class="list-komentar">
        <!-- Daftar komentar -->
        <?php foreach ($komentar as $komen): ?>
            <div class="komentar-item">
                <div class="bubble">
                    <div class="komentar-nama"><strong><?= htmlspecialchars($komen->nama) ?></strong></div>
                    <div class="komentar-teks"><?= nl2br(htmlspecialchars($komen->komentar)) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <form class="form-komentar" method="post" action="<?= base_url('home/tambahKomentar') ?>">
             
        <input type="text" name="nama" placeholder="Nama Anda" class="input-nama" required>
        <input type="text" name="komentar" placeholder="Tulis komentar..." class="input-komentar" required>
        <button type="submit" class="btn"><i class="fas fa-paper-plane"></i></button>
    </form>
</div>

        </div>
    </div>
</section>
<!-- Contact Section End -->
 
   
    <!-- Footer Section Start -->
    <footer>
        <div class="sosials">
            <a href="#"><i data-feather="instagram"></i></a>
            <a href="#"><i data-feather="twitter"></i></a>
            <a href="#"><i data-feather="facebook"></i></a>
        </div>

        <div class="links">
            <a href="#home">Home</a>
            <a href="#about">Tentang Kami</a>
            <a href="#menu">Program Kami</a>
            <a href="#menu">Gallery</a>
            <a href="#contact">Kontak</a>        
        </div>        

        <div class="credit">
            <p>Created by <a href="">triabela</a>. | &copy; 2025.</p>
        </div>
    </footer>
    <!-- Footer Section End -->


    <script>
      // Inisialisasi Feather Icons
      document.addEventListener('DOMContentLoaded', function() {
          feather.replace();
      });

      // Toggle menu mobile
      const hamburger = document.querySelector('#hamburger-menu');
      const navbarNav = document.querySelector('.navbar-nav');

      hamburger.addEventListener('click', function() {
          navbarNav.classList.toggle('active');
      });

      // Tutup menu saat klik di luar navbar
      document.addEventListener('click', function(e) {
          if(!hamburger.contains(e.target) && !navbarNav.contains(e.target)) {
              navbarNav.classList.remove('active');
          }
      });      
    </script>
    <!-- My javascript -->
    <script src="js/script.js"></script>
</body>
</html>