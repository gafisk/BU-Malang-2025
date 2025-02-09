<?php
include '../../../connections/conn.php';

// Data Koordinator
// Ambil daftar divisi kecuali BPHI dan Kesekretariatan
$divisi_query = $conn->query("SELECT * FROM divisi WHERE nama_divisi NOT IN ('BPHI', 'Kesekretariatan') ORDER BY id_divisi ASC");

$divisi_data = [];

// Ambil data divisi dan buat struktur array awal
while ($divisi = $divisi_query->fetch_assoc()) {
    $nama_divisi = $divisi['nama_divisi'];

    // Gunakan nama_divisi sebagai kunci utama array
    $divisi_data[$nama_divisi] = [
        'Koordinator' => [],
        'Anggota' => []
    ];
}

// Ambil anggota yang termasuk dalam divisi yang sudah dipilih
$anggota_query = $conn->query("SELECT a.*, d.nama_divisi 
                               FROM anggota_divisi a 
                               INNER JOIN divisi d ON a.id_divisi = d.id_divisi 
                               WHERE d.nama_divisi NOT IN ('BPHI', 'Kesekretariatan') 
                               ORDER BY d.nama_divisi, a.status");

// Masukkan anggota ke dalam divisi yang sesuai
while ($anggota = $anggota_query->fetch_assoc()) {
    $nama_divisi = $anggota['nama_divisi'];
    $status = $anggota['status']; // Bisa 'Koordinator' atau 'Anggota'

    // Pastikan divisi ada sebelum menambahkan anggota
    if (isset($divisi_data[$nama_divisi])) {
        $divisi_data[$nama_divisi][$status][] = $anggota;
    }
}

// Bagian BPHI
$bphi_query = $conn->query("SELECT * FROM anggota_divisi 
                            INNER JOIN divisi USING(id_divisi) 
                            WHERE nama_divisi = 'BPHI' 
                            AND status IN ('Ketua', 'Wake1', 'Wake2', 'Sekretaris', 'Bendahara')");

// Inisialisasi array untuk menyimpan hasil
$bphi_data = [];

// Masukkan data ke dalam array sesuai statusnya
while ($row = $bphi_query->fetch_assoc()) {
    $status = $row['status'];
    $bphi_data[$status] = $row;
}

// Bagian divisi kesekretariatan
$ang_sekret = $conn->query("SELECT * FROM anggota_divisi INNER JOIN divisi USING(id_divisi) WHERE nama_divisi = 'Kesekretariatan' AND status = 'Anggota'");

?>
<!DOCTYPE html>
<html lang="en">

<?php include '../../../components/head.php' ?>

<style>
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.5);
        /* Warna latar belakang */
        border-radius: 50%;
        /* Membuat ikon berbentuk lingkaran */
        width: 50px;
        height: 50px;
    }
</style>

<body class="index-page">

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
                <?php include '../../../components/navbar.php' ?>
            </div>

        </div>

    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero1 section light-background">

            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-8 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
                        <h1>Profil Pengurus</h1>
                        <p>Insan Cerdas dan Kompetitif</p>
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <!-- Team Section -->
        <section id="team" class="team section light-background">

            <!-- Bootstrap 5 Carousel -->
            <div id="teamCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#teamCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#teamCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#teamCarousel" data-bs-slide-to="2"></button>
                    <button type="button" data-bs-target="#teamCarousel" data-bs-slide-to="3"></button>
                    <button type="button" data-bs-target="#teamCarousel" data-bs-slide-to="4"></button>
                    <button type="button" data-bs-target="#teamCarousel" data-bs-slide-to="5"></button>
                    <button type="button" data-bs-target="#teamCarousel" data-bs-slide-to="6"></button>
                    <button type="button" data-bs-target="#teamCarousel" data-bs-slide-to="7"></button>
                </div>

                <div class="carousel-inner">
                    <!-- Slide 1: Divisi BPHI -->
                    <div class="carousel-item active">
                        <div class="container section-title" data-aos="fade-up">
                            <p><span class="description-title">Badan Pengurus</span> <span>Harian Inti</span></p>
                        </div>
                        <div class="container">
                            <!-- Ketua di baris sendiri -->
                            <div class="row gy-4 justify-content-center mb-3">
                                <?php if (isset($bphi_data['Ketua'])): ?>
                                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                                        <div class="team-member">
                                            <div class="member-img">
                                                <img src="adminbu/assets/assets/pengurus/<?= $bphi_data['Ketua']['gambar']; ?>" class="img-fluid" alt="BPHI" style="width: 300px; height:300px">
                                                <div class="social">
                                                    <a href="<?= $bphi_data['Ketua']['instagram'] ?>"><i class="bi bi-instagram"></i></a>
                                                    <a href="<?= $bphi_data['Ketua']['linkedin'] ?>"><i class="bi bi-linkedin"></i></a>
                                                </div>
                                            </div>
                                            <div class="member-info">
                                                <span>Ketua Umum</span>
                                                <h4><?= $bphi_data['Ketua']['nama_anggota'] ?></h4>
                                                <span><?= $bphi_data['Ketua']['univ_anggota'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Baris Anggota (Wakil Ketua, Sekretaris, Bendahara) -->
                            <div class="row gy-4 justify-content-center">
                                <?php
                                $positions = [
                                    'Wake1' => 'Wakil Ketua I',
                                    'Wake2' => 'Wakil Ketua II',
                                    'Sekretaris' => 'Sekretaris',
                                    'Bendahara' => 'Bendahara'
                                ];

                                foreach ($positions as $key => $title):
                                    if (isset($bphi_data[$key])):
                                ?>
                                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                                            <div class="team-member">
                                                <div class="member-img">
                                                    <img src="adminbu/assets/assets/pengurus/<?= $bphi_data[$key]['gambar']; ?>" class="img-fluid" alt="BPHI" style="width: 300px; height:300px">
                                                    <div class="social">
                                                        <?php if (!empty($bphi_data[$key]['instagram'])): ?>
                                                            <a href="<?= $bphi_data[$key]['instagram'] ?>"><i class="bi bi-instagram"></i></a>
                                                        <?php endif; ?>
                                                        <?php if (!empty($bphi_data[$key]['linkedin'])): ?>
                                                            <a href="<?= $bphi_data[$key]['linkedin'] ?>"><i class="bi bi-linkedin"></i></a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="member-info">
                                                    <span><?= $title ?></span>
                                                    <h4><?= $bphi_data[$key]['nama_anggota'] ?></h4>
                                                    <span><?= $bphi_data[$key]['univ_anggota'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Divisi Dengan Koordinator -->
                    <?php foreach ($divisi_data as $nama_divisi => $data) {
                    ?>
                        <div class="carousel-item">
                            <div class="container section-title" data-aos="fade-up">
                                <p><span class="description-title">Divisi</span> <span><?php echo $nama_divisi; ?></span></p>
                            </div>
                            <div class="container">
                                <!-- Baris Koordinator -->
                                <div class="row gy-4 justify-content-center mb-3">
                                    <?php foreach ($data['Koordinator'] as $koor) { ?>
                                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                                            <div class="team-member">
                                                <div class="member-img">
                                                    <img src="adminbu/assets/assets/pengurus/<?php echo $koor['gambar']; ?>" class="img-fluid" alt="Koordinator" style="width: 300px; height:300px">
                                                    <div class="social">
                                                        <a href="<?php echo $koor['instagram']; ?>"><i class="bi bi-instagram"></i></a>
                                                        <a href="<?php echo $koor['linkedin']; ?>"><i class="bi bi-linkedin"></i></a>
                                                    </div>
                                                </div>
                                                <div class="member-info">
                                                    <span>Koordinator</span>
                                                    <h4><?php echo $koor['nama_anggota']; ?></h4>
                                                    <span><?php echo $koor['univ_anggota']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <!-- Baris Anggota -->
                                <div class="row gy-4 justify-content-center">
                                    <?php foreach ($data['Anggota'] as $anggota) { ?>
                                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                                            <div class="team-member">
                                                <div class="member-img">
                                                    <img src="adminbu/assets/assets/pengurus/<?php echo $anggota['gambar']; ?>" class="img-fluid" alt="Anggota" style="width: 300px; height:300px">
                                                    <div class="social">
                                                        <a href="<?php echo $anggota['instagram']; ?>"><i class="bi bi-instagram"></i></a>
                                                        <a href="<?php echo $anggota['linkedin']; ?>"><i class="bi bi-linkedin"></i></a>
                                                    </div>
                                                </div>
                                                <div class="member-info">
                                                    <h4><?php echo $anggota['nama_anggota']; ?></h4>
                                                    <span><?php echo $anggota['univ_anggota']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <!-- End::Bagian Divisi Dengan Koordinator -->

                    <!-- Slide 8: TIM Kesekretariatan -->
                    <div class="carousel-item">
                        <div class="container section-title" data-aos="fade-up">
                            <p><span class="description-title">Tim</span> <span>Kesekretariatan</span> </p>
                        </div>
                        <div class="container">
                            <div class="row gy-4 justify-content-center">
                                <?php while ($row = $ang_sekret->fetch_assoc()) { ?>
                                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                                        <div class="team-member">
                                            <div class="member-img">
                                                <img src="adminbu/assets/assets/pengurus/<?php echo $row['gambar']; ?>" class="img-fluid" alt="Anggota" style="width: 300px; height:300px">
                                                <div class="social">
                                                    <a href="<?php echo $row['instagram']; ?>"><i class="bi bi-instagram"></i></a>
                                                    <a href="<?php echo $row['linkedin']; ?>"><i class="bi bi-linkedin"></i></a>
                                                </div>
                                            </div>
                                            <div class="member-info">
                                                <h4><?php echo $row['nama_anggota']; ?></h4>
                                                <span><?php echo $row['univ_anggota']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigasi -->
                <button class="carousel-control-prev" type="button" data-bs-target="#teamCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#teamCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>


        </section><!-- /Team Section -->

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

            <?php include '../../../components/footer.php' ?>
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
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>


    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>