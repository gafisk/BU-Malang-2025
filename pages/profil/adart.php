<?php
include '../../connections/conn.php';
// Data konten
$query = "SELECT link_adart FROM pelaporan LIMIT 1"; // Batasi hanya satu baris
$result = $conn->query($query);

$contents = [];
if ($result && $row = $result->fetch_assoc()) {
    $contents = [
        "link_adart" => $row['link_adart'],
    ];
}
$drive_url = $contents['link_adart'];
preg_match('/\/d\/([^\/]+)/', $drive_url, $match);
$file_id = $match[1] ?? '';


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

$conn->close();

?>


<!DOCTYPE html>
<html lang="en">

<?php include '../../components/head.php' ?>

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
                <?php include '../../components/navbar.php' ?>
            </div>

        </div>

    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero1 section light-background">

            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-8 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
                        <h1>Anggaran Dasar & Anggaran Rumah Tangga</h1>
                        <p>Insan Cerdas dan Kompetitif</p>
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <!-- contents Section -->
        <section id="contents" class="contents section">
            <div class="container section-title" data-aos="fade-up">
                <p><span>AD/ART</span> <span class="description-title">BU Malang</span></p>
            </div>

            <div class="container text-center py-4">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <h4 class="card-title fw-bold">
                            <i class="bi bi-file-earmark-text-fill text-primary"></i> Kenali dan Pahami AD/ART Forum BU Malang!
                        </h4>
                        <p class="card-text text-muted">
                            Anggaran Dasar dan Anggaran Rumah Tangga (AD/ART) adalah pedoman utama dalam menjalankan organisasi <strong>Forum Beasiswa Unggulan Malang</strong>.
                            Dokumen ini mengatur landasan, struktur organisasi, serta hak dan kewajiban anggota dalam membangun komunitas yang lebih solid,
                            transparan, dan berkelanjutan.
                        </p>
                        <p class="card-text text-muted">
                            Dengan memahami AD/ART, setiap anggota dapat lebih aktif berkontribusi dan memastikan bahwa kegiatan organisasi berjalan sesuai dengan visi dan misi yang telah ditetapkan.
                            Mari bersama-sama menjaga komitmen dan profesionalisme dalam setiap langkah yang kita ambil.
                        </p>
                        <p class="card-text fw-bold">
                            Akses dan pelajari AD/ART kami dengan mengklik tombol di bawah ini.
                        </p>

                        <!-- Tombol untuk membuka modal -->
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#pdfModal">
                            <i class="bi bi-file-earmark-pdf"></i> Baca AD/ART Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal AD/ART -->
            <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="pdfModalLabel">
                                <i class="bi bi-file-earmark-pdf-fill text-danger"></i> AD/ART Forum BU Malang
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <iframe src="https://drive.google.com/file/d/<?= $file_id; ?>/preview" width="100%" height="500px"></iframe>
                        </div>
                        <div class="modal-footer">
                            <a href="https://drive.google.com/file/d/<?= $file_id; ?>/view" target="_blank" class="btn btn-danger">
                                <i class="bi bi-box-arrow-up-right"></i> Buka di Tab Baru
                            </a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle"></i> Tutup
                            </button>
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

            <?php include '../../components/footer.php' ?>
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