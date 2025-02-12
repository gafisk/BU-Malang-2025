<?php
include '../../connections/conn.php';
// Pastikan koneksi database sudah ada di atas

// Periksa apakah 'id' ada di URL
// Periksa apakah 'id' ada di URL
if (isset($_GET['id'])) {
    $id_berita = $_GET['id'];

    // Validasi ID harus berupa angka
    if (!filter_var($id_berita, FILTER_VALIDATE_INT)) {
        die("ID tidak valid!");
    }

    // Query untuk mengambil data berita berdasarkan id_proker
    $stmt = $conn->prepare("SELECT * FROM berita WHERE id_berita = ? AND status = 'Published'");
    $stmt->bind_param("i", $id_berita);
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah data ditemukan
    if ($row = $result->fetch_assoc()) {
        $judul_berita = htmlspecialchars($row['judul_berita']);
        $isi_berita = $row['isi_berita']; // Menjaga format paragraf
        $waktu = date('l, d F Y', strtotime($row['waktu'])); // Format tanggal
        $gambar = !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : null; // Cek gambar
    } else {
        echo "<script>alert('Berita tidak ditemukan!'); window.location='berita.php';</script>";
        exit;
    }

    $stmt->close();
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location='berita.php';</script>";
    exit;
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
        <section id="contents" class="contents section">
            <div class="container mt-4">
                <!-- Judul Berita -->
                <h1 class="mb-3 text-center fw-bold border-bottom pb-2"><?= $judul_berita; ?></h1>

                <!-- Tanggal Berita -->
                <p class="text-muted text-center">
                    <i class="bi bi-calendar me-2"></i> <?= $waktu; ?>
                </p>

                <div class="card p-4 shadow-lg border-0">
                    <!-- Tampilkan Gambar -->
                    <?php if (!empty($gambar)) : ?>
                        <div class="text-center mb-3">
                            <img src="/BU-Malang-2025/adminbu/assets/assets/berita/<?= $gambar; ?>"
                                alt="Gambar Berita" class="img-fluid rounded shadow"
                                style="max-width: 60%; height: auto;">
                        </div>
                    <?php endif; ?>

                    <?= $isi_berita; ?>

                    <!-- Tombol Kembali -->
                    <div class="text-center mt-4">
                        <a href="javascript:history.back()" class="btn btn-outline-secondary btn-lg shadow-sm">
                            <i class="bi bi-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </section>
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