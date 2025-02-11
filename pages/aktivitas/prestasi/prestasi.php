<?php
include '../../../connections/conn.php';
// Data konten
$contents = [];

$query = "SELECT * FROM prestasi ORDER BY waktu DESC";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $contents[] = [
        "id_prestasi" => $row['id_prestasi'],
        "waktu" => date('l, d F Y', strtotime($row['waktu'])), // Format tanggal: Senin, 29 Juli 2001
        "nama_prestasi" => $row['nama_prestasi'],
        "tingkat_prestasi" => $row['tingkat_prestasi'],
        "nama_peraih" => $row['nama_peraih'],
        "asal_univ" => $row['asal_univ'],
    ];
}

// Pagination
$perPage = 6; // Konten per halaman
$total = count($contents); // Total konten
$totalPages = ceil($total / $perPage); // Total halaman

// Halaman aktif
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$page = min($page, $totalPages);

// Konten yang ditampilkan
$start = ($page - 1) * $perPage;
$displayContents = array_slice($contents, $start, $perPage);

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
                        <h1>Prestasi Awardee</h1>
                        <p>Insan Cerdas dan Kompetitif</p>
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <!-- contents Section -->
        <section id="contents" class="contents section">
            <div class="container section-title" data-aos="fade-up">
                <p><span>Cek Prestasi Awardee</span> <span class="description-title">BU Malang</span></p>
            </div>

            <div class="container">
                <div class="row gy-3">
                    <?php foreach ($displayContents as $content): ?>
                        <div class="col-xl-6 col-lg-12" data-aos="fade-up">
                            <div class="contents-item">
                                <h3><?= $content['waktu']; ?></h3>
                                <table class="table">
                                    <tr>
                                        <th class="text-start">Nama Prestasi</th>
                                        <td>:</td>
                                        <td class="text-start"><?= $content['nama_prestasi']; ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-start">Tingkat</th>
                                        <td>:</td>
                                        <td class="text-start"><?= $content['tingkat_prestasi']; ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-start">Peraih</th>
                                        <td>:</td>
                                        <td class="text-start"><?= $content['nama_peraih']; ?></td>
                                    </tr>
                                    <tr>
                                        <th class="text-start">Asal Universitas</th>
                                        <td>:</td>
                                        <td class="text-start"><?= $content['asal_univ']; ?></td>
                                    </tr>
                                </table>
                                <div class="btn-wrap">
                                    <a href="pages/aktivitas/prestasi/pages-prestasi.php?id=<?= $content['id_prestasi']; ?>" class="btn btn-primary">Check it</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <nav>
                    <ul class="pagination justify-content-center pt-5">
                        <!-- Tombol Previous -->
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= $_SERVER['PHP_SELF']; ?>?page=<?= $page - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- Nomor Halaman -->
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="<?= $_SERVER['PHP_SELF']; ?>?page=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <!-- Tombol Next -->
                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= $_SERVER['PHP_SELF']; ?>?page=<?= $page + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
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