<?php
include '../../../connections/conn.php';
// Data konten
$query = "SELECT link_prestasi FROM pelaporan LIMIT 1"; // Batasi hanya satu baris
$result = $conn->query($query);

$contents = [];
if ($result && $row = $result->fetch_assoc()) {
    $contents = [
        "link_prestasi" => $row['link_prestasi'],
    ];
}


// footer
$footer = [];
$query = "SELECT * FROM footer";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$footer = [
    "alamat_bu" => $row['alamat_bu'],
    "nomor_bu" => $row['nomor_bu'],
    "email_bu" => $row['email_bu'],
    "youtube_bu" => $row['youtube_bu'],
    "ig_bu" => $row['ig_bu'],
    "linkedin_bu" => $row['linkedin_bu'],
    "pengembang_bu" => $row['pengembang_bu'],
];

function formatNomorWA($nomor)
{
    // Hapus semua karakter selain angka
    $nomor = preg_replace('/[^0-9]/', '', $nomor);

    // Jika nomor diawali dengan 0, ubah menjadi 62
    if (substr($nomor, 0, 1) === '0') {
        $nomor = '62' . substr($nomor, 1);
    }

    return $nomor;
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<?php include '../../../components/head.php' ?>

<body class="index-page">

    <header id="header" class="header sticky-top">

        <div class="topbar d-flex align-items-center">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="contact-info d-flex align-items-center">
                    <i class="bi bi-envelope d-flex align-items-center"><a href="<?= $footer['email_bu'] ?>"><?= $footer['email_bu'] ?></a></i>
                    <i class="bi bi-phone d-flex align-items-center ms-4"><span><?= $footer['nomor_bu'] ?></span></i>
                </div>
                <div class="social-links d-none d-md-flex align-items-center">
                    <a href="<?= $footer['youtube_bu'] ?>" class="youtube"><i class="bi bi-youtube"></i></a>
                    <a href="<?= $footer['ig_bu'] ?>" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="<?= $footer['linkedin_bu'] ?>" class="linkedin"><i class="bi bi-linkedin"></i></a>
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
                        <h1>Pelaporan Prestasi</h1>
                        <p>Insan Cerdas dan Kompetitif</p>
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <!-- contents Section -->
        <section id="contents" class="contents section">
            <div class="container section-title" data-aos="fade-up">
                <p><span>Pelaporan Prestasi Awardee</span> <span class="description-title">BU Malang</span></p>
            </div>

            <div class="container text-center py-4">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <h4 class="card-title fw-bold">
                            <i class="bi bi-trophy-fill text-warning"></i> Banggakan Prestasimu, Laporkan Sekarang!
                        </h4>
                        <p class="card-text text-muted">
                            Apakah Anda baru saja meraih prestasi membanggakan? Kami ingin mendengar kabar baik dari Anda!
                            Baik itu penghargaan akademik, kejuaraan nasional, publikasi ilmiah, atau pencapaian lainnya,
                            data prestasi Anda sangat berarti bagi <strong>Forum Awardee Beasiswa Unggulan Malang</strong> dan inspirasi bagi generasi berikutnya.
                            Laporkan pencapaian Anda dan jadilah bagian dari jaringan awardee berprestasi !
                        </p>
                        <p class="card-text fw-bold">
                            Klik tombol di bawah untuk mengisi data prestasi Anda dan terus bersinar bersama awardee lainnya!
                        </p>
                        <a href="<?= $contents['link_prestasi']; ?>" class="btn btn-warning mb-3" target="_blank">
                            <i class="bi bi-pencil-square"></i> Laporkan Prestasi
                        </a>
                        <div class="mt-3">
                            <p class="text-muted mb-1">
                                <i class="bi bi-info-circle-fill text-primary"></i> Ada pertanyaan atau kendala? Hubungi kami melalui WhatsApp!
                            </p>
                            <a href="https://wa.me/<?= formatNomorWA($footer['nomor_bu']) ?>" class="btn btn-success" target="_blank">
                                <i class="bi bi-whatsapp"></i> Hubungi Narahubung
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- /contents Section -->

    </main>

    <footer id="footer" class="footer">
        <div class="footer-newsletter">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-6">
                        <h3>Forum Beasiswa Unggulan Malang</h5>
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

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>