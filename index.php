<?php
include 'connections/conn.php';

// Untuk Stats
$query_stats = "SELECT * FROM stats_awardee";
$result_stats = $conn->query($query_stats);
$jumlah_awardee = [
  "Sarjana" => 0,
  "Magister" => 0,
  "Doktor" => 0
];
while ($row_stats = $result_stats->fetch_assoc()) {
  $jumlah_awardee[$row_stats['keterangan']] = $row_stats['jumlah'];
}

// Query untuk menghitung jumlah total data di tabel kampus_awardee
$query_kampus = "SELECT COUNT(*) as total FROM kampus_awardee";
$result_kampus = $conn->query($query_kampus);
$row_kampus = $result_kampus->fetch_assoc();
$total_kampus_awardee = $row_kampus['total'];

// Query untuk mengambil semua gambar dari tabel kampus_awardee
$query_kampus = "SELECT gambar FROM kampus_awardee";
$result_kampus = $conn->query($query_kampus);

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php' ?>

<body class="index-page">
  <audio id="bg-music" muted loop>
    <source src="assets/music/mars.mp3" type="audio/mp3">
    Browser tidak mendukung audio.
  </audio>

  <script>
    document.addEventListener("click", function() {
      var audio = document.getElementById("bg-music");
      audio.muted = false; // Matikan mute setelah klik
      audio.play();
    });
  </script>


  <header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">contact@example.com</a></i>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>+1 5589 55488 55</span></i>
        </div>
        <div class="social-links d-none d-md-flex align-items-center">
          <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </div><!-- End Top Bar -->


    <div class="branding d-flex align-items-cente">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <?php include 'components/navbar.php' ?>
      </div>

    </div>

  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section light-background">

      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-8 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
            <h1>Selamat Datang di Forum <span>Beasiswa Unggulan Malang</span></h1>
            <p>Insan Cerdas dan Kompetitif</p>
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- Pricing Section -->
    <section id="sejarah" class="pricing section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Sejarah</h2>
        <p><span>Sejarah Beasiswa Unggulan</span> <span class="description-title">dan Beasiswa Unggulan Malang</span></p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-3">

          <div class="col-xl-6 col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="pricing-item">
              <h3>Beasiswa Unggulan</h3>
              <p style="text-align: justify;">
                Beasiswa Unggulan atau BU ini telah digelar Kemendikbudristek sejak tahun 2006. Artinya, tahun 2024 ini, BU telah berlangsung selama 18 tahun. BU Kemendikbudristek ini terbagi dua kategori, yakni BU bagi pegawai Kemendikbudsristek dan BU bagi masyarakat berprestasi. BU bagi masyarakat berprestasi diberikan bagi masyarakat yang memiliki kemampuan intelektual, emosional, dan spiritual untuk melanjutkan pendidikan pada jenjang sarjana, magister, dan doktor yang diselenggarakan pada perguruan tinggi dalam negeri atau perguruan tinggi luar negeri.
              </p>
              <p style="text-align: justify;">
                Sejak BU dikelola Pusat Layanan Pembiayaan Pendidikan (Puslapdik) tahun 2020 sampai dengan tahun 2023, jumlah penerima BU sebanyak 6.384 orang dan sampai awal tahun 2024, yaitu di akhir semester ganjil tahun akademik 2023-2024, mahasiswa penerima BU yang masih aktif berjumlah 4.259 orang. Dari sejumlah itu, jenjang S-1/D-4 sebanyak 2.275 orang, jenjang S-2 sebanyak 1.715 orang, dan jenjang S-3 sebanyak 269 orang. Dari sejumlah itu juga, ada 3 orang mahasiswa penyandang disabilitas dan 77 orang mahasiswa berstatus pegawai Kemendikbudristek.
              </p>
            </div>
          </div><!-- End Pricing Item -->

          <div class="col-xl-6 col-lg-6" data-aos="fade-up" data-aos-delay="400">
            <div class="pricing-item">
              <h3>Beasiswa Unggulan Malang</h3>
              <p style="text-align: justify;">
                Forum Awardee Beasiswa Unggulan (BU) Regional Malang Raya merupakan wadah bagi para awardee/penerima BU universitas di wilayah Malang Raya. Dibentuk di Universitas Negeri Malang pada 12 November 2016. Forum ini telah berlangsung selama 8 tahun sejak didirikan, dibentuk dengan tujuan menghimpun dan menjadi wadah silaturahmi, bersinergi, berkolaborasi dan saling menginspirasi antar Awardee/Penerima Beasiswa Unggulan Se-Malang Raya.
              </p>
            </div>
          </div><!-- End Pricing Item -->

        </div>

      </div>

    </section><!-- /Pricing Section -->

    <!-- About Section -->
    <section id="lambang" class="lambang section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Logo BU Malang</h2>
        <p><span>Makna</span> <span class="description-title">Logo BU Malang</span></p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-3">

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <img src="assets/img/Logo.png" alt="" class="img-fluid">
          </div>

          <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <div class="about-content ps-0 ps-lg-3">
              <h3>Launching Logo Tahun 2019</h3>
              <ul>
                <li>
                  <!-- <i class="bi bi-diagram-3"></i> -->
                  <div>
                    <h4>Warna Biru</h4>
                    <p>Merupakan Lambang Pendidikan Indonesia</p>
                  </div>
                </li>
                <li>
                  <!-- <i class="bi bi-fullscreen-exit"></i> -->
                  <div>
                    <h4>Api</h4>
                    <p>Melambangkan Semangat Membara Awardee BU Malang</p>
                  </div>
                </li>
                <li>
                  <!-- <i class="bi bi-fullscreen-exit"></i> -->
                  <div>
                    <h4>Siluet Tugu Kota Malang</h4>
                    <p>Melambangkan Indentitas Kota Malang</p>
                  </div>
                </li>
                <li>
                  <!-- <i class="bi bi-fullscreen-exit"></i> -->
                  <div>
                    <h4>BU MALANG</h4>
                    <p>Merupakan Singkatan Dari Beasiswa Unggulan Malang</p>
                  </div>
                </li>
                <li>
                  <!-- <i class="bi bi-fullscreen-exit"></i> -->
                  <div>
                    <h4>Buku</h4>
                    <p>Melambangkan Jendela Ilmu Pengetahuan</p>
                  </div>
                </li>
                <li>
                  <!-- <i class="bi bi-fullscreen-exit"></i> -->
                  <div>
                    <h4>Warna Emas</h4>
                    <p>Melambangkan Kesuksesan dan Prestasi</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <p class="fst-italic">
            Arti logo Forum BU Malang bukan hanya sekedar simbol, melainkan cerminan semangat kebersamaan, inovasi dan visi yang menyatukan para penerima beasiswa dalam tujuan yang sama. Setiap elemen dirancang dengan makna tersendiri, menggambarkan bagaimana kolaborasi dan sinergi diantara para awardee menjadi sebuah fondasi kokoh untuk menciptakan perubahan positif.
          </p>
        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Stats Section -->
    <section id="stats" class="stats section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="bi bi-bank"></i> <!-- Simbol gedung universitas -->
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="<?= $total_kampus_awardee; ?>" data-purecounter-duration="1" class="purecounter"></span>
              <p>Kampus Awardee</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="bi bi-mortarboard"></i> <!-- Topi wisuda -->
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="<?= $jumlah_awardee['Sarjana']; ?>" data-purecounter-duration="1" class="purecounter"></span>
              <p>Awardee Program Sarjana</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="bi bi-mortarboard"></i> <!-- Topi wisuda -->
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="<?= $jumlah_awardee['Magister']; ?>" data-purecounter-duration="1" class="purecounter"></span>
              <p>Awardee Program Magister</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="bi bi-mortarboard"></i> <!-- Topi wisuda -->
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="<?= $jumlah_awardee['Doktor']; ?>" data-purecounter-duration="1" class="purecounter"></span>
              <p>Awardee Program Doktor</p>
            </div>
          </div><!-- End Stats Item -->

        </div>

      </div>

    </section><!-- /Stats Section -->

    <!-- Clients Section -->
    <section id="clients" class="clients section light-background">

      <div class="container">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "spaceBetween": 40
                },
                "480": {
                  "slidesPerView": 3,
                  "spaceBetween": 60
                },
                "640": {
                  "slidesPerView": 4,
                  "spaceBetween": 80
                },
                "992": {
                  "slidesPerView": 6,
                  "spaceBetween": 120
                }
              }
            }
          </script>
          <div class="swiper-wrapper align-items-center">
            <!-- Looping untuk menampilkan gambar kampus -->
            <?php while ($row_kampus = $result_kampus->fetch_assoc()): ?>
              <div class="swiper-slide">
                <img src="adminbu/assets/assets/kampus/<?= htmlspecialchars($row_kampus['gambar']); ?>" class="img-fluid" alt="Logo Kampus">
              </div>
            <?php endwhile; ?>
          </div>
        </div>

      </div>

    </section><!-- /Clients Section -->

  </main>

  <footer id="footer" class="footer">

    <div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-lg-6">
            <h4>Join Our Newsletter</h4>
            <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
            <form action="forms/newsletter.php" method="post" class="php-email-form">
              <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your subscription request has been sent. Thank you!</div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="container footer-top">
      <?php include 'components/footer.php' ?>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Pengurus BU Malang</strong> <span>2024</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
  </div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>