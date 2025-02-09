<?php
include '../../../connections/conn.php';
// Pastikan koneksi database sudah ada di atas

// Periksa apakah 'id' ada di URL
// Periksa apakah 'id' ada di URL
if (isset($_GET['id'])) {
    $id_prestasi = $_GET['id'];

    // Validasi ID harus berupa angka
    if (!filter_var($id_prestasi, FILTER_VALIDATE_INT)) {
        die("ID tidak valid!");
    }

    // Query untuk mengambil data berita berdasarkan id_proker
    $stmt = $conn->prepare("SELECT * FROM prestasi WHERE id_prestasi = ?");
    $stmt->bind_param("i", $id_prestasi);
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah data ditemukan
    if ($row = $result->fetch_assoc()) {
        $nama_prestasi = htmlspecialchars($row['nama_prestasi']);
        $tingkat_prestasi = htmlspecialchars($row['tingkat_prestasi']);
        $nama_peraih = htmlspecialchars($row['nama_peraih']);
        $asal_univ = htmlspecialchars($row['asal_univ']);
        $tahun_awardee = htmlspecialchars($row['tahun_awardee']);
        $waktu = date('l, d F Y', strtotime($row['waktu'])); // Format tanggal
        $gambar = !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : null; // Cek gambar
    } else {
        echo "<script>alert('Prestasi tidak ditemukan!'); window.location='prestasi.php';</script>";
        exit;
    }

    $stmt->close();
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location='prestasi.php';</script>";
    exit;
}

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
        <section id="contents" class="contents section">
            <div class="container mt-4">
                <h1 class="mb-3">Prestasi Awardee Beasiswa Unggulan Malang</h1>
                <p class="text-muted"><i class="bi bi-calendar"></i> <?= $waktu; ?></p>

                <div class="card p-4 shadow-sm">
                    <!-- Tampilkan Gambar -->
                    <?php if (!empty($gambar)) : ?>
                        <img src="/BU-Malang-2025/adminbu/assets/assets/prestasi/<?= $gambar; ?>"
                            alt="Gambar Berita" class="img-fluid mb-3" style="max-width: 30%; height: auto;">
                    <?php endif; ?>

                    <p><strong>Selamat dan Sukses! 🎉🏆</strong></p>

                    <p>Kami dengan bangga mengucapkan selamat kepada <strong><?= $nama_peraih ?></strong> dari <strong><?= $asal_univ ?></strong> atas prestasi luar biasa sebagai <strong><?= $nama_prestasi ?></strong> pada tingkat <strong><?= $tingkat_prestasi ?></strong>.</p>

                    <p>Keberhasilan ini menjadi bukti nyata dari dedikasi, kerja keras, dan bakat luar biasa yang telah diasah dengan penuh ketekunan. Lebih dari itu, pencapaian ini semakin istimewa karena <strong><?= $nama_peraih ?></strong> juga merupakan bagian dari <strong>Awardee Beasiswa Unggulan Malang Tahun <?= $tahun_awardee ?></strong>, komunitas unggul yang terdiri dari individu-individu berprestasi dengan semangat tinggi dalam mengembangkan diri dan berkontribusi bagi masyarakat.</p>

                    <p>Prestasi ini bukan hanya kebanggaan pribadi, tetapi juga kebanggaan bagi almamater dan seluruh awardee Beasiswa Unggulan. Semoga pencapaian ini menjadi inspirasi bagi banyak orang untuk terus berusaha, berkarya, dan mengukir lebih banyak prestasi di masa depan.</p>

                    <p>Sekali lagi, selamat atas keberhasilan ini! Teruslah menginspirasi, mengukir prestasi, dan membawa perubahan positif bagi lingkungan sekitar. 🚀✨👏</p>

                    <!-- Tambahan Link -->
                    <?php if (!empty($link)) : ?>
                        <p class="mt-3">
                            Baca berita terkait:
                            <a href="<?= $link; ?>" target="_blank" class="text-primary fw-bold">
                                <?= $judul_link ?: "Klik di sini"; ?>
                            </a>
                        </p>
                    <?php endif; ?>

                    <!-- Tombol Kembali -->
                    <a href="javascript:history.back()" class="btn btn-secondary mt-3">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </section>


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