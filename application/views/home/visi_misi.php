<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil LKSA/Panti Asuhan Nadhief Senon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/profile.css'); ?>" rel="stylesheet">
</head>
<body>
    <div class="bg-image">
        <div class="overlay"></div>
        <div class="container py-5 content-area">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="content-box">
                        <h2 class="text-center section-title">Profil LKSA/Panti Asuhan Nadhief Senon</h2>
                        <hr>

                        <ul class="nav nav-tabs mb-4 nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tentang">Sejarah</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#visi-misi">Visi & Misi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#struktur">Struktur Pengurus</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="tentang" class="tab-pane fade show active">
                                <h4 class="text-primary">Sejarah Singkat</h4>
                                <p class="text-justify text-dark">
                                    Kegiatan kepedulian terhadap anak yatim, piatu, dan terlantar dimulai sejak 1990 dengan menitipkan mereka ke panti asuhan di wilayah Purbalingga, Banyumas, dan Cilacap. Sejak 2000, kegiatan berganti menjadi pemberian santunan langsung hingga 2006.
                                    Mulai 2006, didirikan panti sendiri yang kemudian berganti nama beberapa kali dan bergabung dengan berbagai yayasan, di antaranya Al Ma’un, Nadhief, Baitul Maal BRI, dan Himmatussalam.
                                    Pada 2014, pengurus kembali memakai nama Panti Asuhan Nadhief Senon, dan sejak 2019 menyesuaikan dengan kebijakan pemerintah menjadi LKSA Nadhief Senon. Saat ini panti beroperasi mandiri dan terus berkembang.
                                </p>
                            </div>

                            <div id="visi-misi" class="tab-pane fade">
                                <h4 class="text-success">Visi</h4>
                                <p class="text-dark">
                                    Menjadi  Lembaga  Kesejahteraan Sosial Anak  sebagai  Panti  Asuhan  yang berkultur  pesantren,
                                    terkelola secara profesional, transparan dan akuntabel untuk dapat memberikan  sumbangan yang
                                    nyata  pada peningkatan kesejateraan sosial  masyarakat.
                                </p>
                                <h4 class="mt-3 text-success">Misi</h4>
                                <ul class="text-dark">
                                    <li>Menyelenggarakan  kegiatan  asuhan dengan kultur  pesantren.</li>
                                    <li>Menyelenggarakan kegiatan Pendidikan Al Quran/Agama Islam bagi anak asuh dan  masyarakat
                                        sekitarnya.</li>
                                    <li>Mengupayakan Pengembangan bakat dan ketrampilan (hard skill/soft skill) anak asuh dan
                                        masyarakat sekitarnya yang disesuaikan dengan minat  dan bakat anak.</li>
                                    <li>Memberikan  kesempatan  bagi  anak  asuh  untuk  dapat  menyelesaikan  pendidikan  sampai  tingkat
                                        SLTA.</li>
                                    <li>Menyelenggarakan  bimbingan  les privat bagi anak  asuh dan masyarakat sekitarnya.</li>
                                    <li>Mengupayakan  Peningkatan  kemampuan  kelembagaan  dan  pelayanan  panti  asuhan  sebagai
                                        LKSA berkultur pesantren yang terkelola secara profesional,  transparan dan akuntabel.</li>
                                </ul>
                            </div>

                            <div id="struktur" class="tab-pane fade">
                                <h4 class="text-center mb-4 text-info">Struktur Kepengurusan LKSA Nadhief Senon</h4>
                                <div class="text-center">
                                    <img src="<?php echo base_url('assets/gambar/strukturpanti.png'); ?>" alt="Struktur Pengurus" class="img-fluid rounded shadow">
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="<?php echo site_url('home'); ?>" class="btn btn-outline-primary">Kembali ke Beranda</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
