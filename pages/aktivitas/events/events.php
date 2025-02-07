<?php
// Data konten
$contents = [
    ["title" => "Senin, 29 Juli 2001", "items" => "Berita Terbaruuu"],
    ["title" => "Senin, 29 Juli 2001", "items" => "Berita Terbaruuu"],
    ["title" => "Senin, 29 Juli 2001", "items" => "Berita Terbaruuu"],
    ["title" => "Senin, 29 Juli 2001", "items" => "Berita Terbaruuu"],
    ["title" => "Senin, 29 Juli 2001", "items" => "Berita Terbaruuu"],
    ["title" => "Senin, 29 Juli 2001", "items" => "Berita Terbaruuu"],
    ["title" => "Senin, 29 Juli 2001", "items" => "Berita Terbaruuu"],
    ["title" => "Senin, 29 Juli 2001", "items" => "Berita Terbaruuu"],
    ["title" => "Senin, 29 Juli 2001", "items" => "Berita Terbaruuu"],
    ["title" => "Senin, 29 Juli 2001", "items" => "Berita Terbaruuu"],
];

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
?>


<!DOCTYPE html>
<html lang="en">

<?php include '../../../components/head.php' ?>

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
                        <h1>Events</h1>
                        <p>Insan Cerdas dan Kompetitif</p>
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <!-- contents Section -->
        <section id="contents" class="contents section">
            <div class="container section-title" data-aos="fade-up">
                <p><span>Cek Events</span> <span class="description-title">BU Malang</span></p>
            </div>

            <div class="container">
                <div class="row gy-3">
                    <div class="row gy-3">
                        <?php foreach ($displayContents as $content): ?>
                            <div class="col-xl-6 col-lg-12" data-aos="fade-up">
                                <div class="contents-item">
                                    <h3><?= $content['title']; ?></h3>
                                    <ul>
                                        <h5><?= $content['items']; ?></h5>
                                    </ul>
                                    <div class="btn-wrap">
                                        <a href="#" class="btn-buy">Check it</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
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

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>