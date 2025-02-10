<?php
include '../../../connections/conn.php';
// Pastikan koneksi database sudah ada di atas

// Periksa apakah 'id' ada di URL
if (isset($_GET['id'])) {
    $id_lapkeu = $_GET['id'];

    // Validasi ID harus berupa angka
    if (!filter_var($id_lapkeu, FILTER_VALIDATE_INT)) {
        die("ID tidak valid!");
    }

    // Query untuk mengambil data berita berdasarkan id_proker
    $stmt = $conn->prepare("SELECT * FROM lap_keuangan WHERE id_lap_keuangan = ?");
    $stmt->bind_param("i", $id_lapkeu);
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah data ditemukan
    if ($row = $result->fetch_assoc()) {
        $kabinet = htmlspecialchars($row['kabinet']);
        $tahun = htmlspecialchars($row['tahun']);
        $waktu = date('l, d F Y', strtotime($row['waktu']));
        $link = htmlspecialchars($row['link']);
    } else {
        echo "<script>alert('Berita tidak ditemukan!'); window.location='laporan-keuangan.php';</script>";
        exit;
    }

    $stmt->close();
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location='laporan-keuangan.php';</script>";
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
        <!-- HTML untuk Menampilkan Detail Berita -->
        <section id="contents" class="contents section">
            <div class="container mt-4">
                <h2 class="mb-3">Laporan Keuangan Kabinet <?= $kabinet; ?> tahun <?= $tahun ?></h2>
                <p class="text-muted"><i class="bi bi-calendar"></i> <?= $waktu; ?></p>

                <div class="card p-4 shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title fw-bold text-primary">
                            <i class="bi bi-cash-stack"></i> Laporan Keuangan Forum BU Malang Kabinet <?= $kabinet ?>
                        </h4>
                        <p class="card-text text-muted">
                            Dalam rangka menjaga transparansi dan akuntabilitas keuangan,
                            <strong>Forum Beasiswa Unggulan Malang Kabinet <?= $kabinet ?> Tahun <?= $tahun ?></strong> dengan ini menyampaikan laporan keuangan yang mencakup seluruh pemasukan dan pengeluaran selama periode kepengurusan.
                        </p>

                        <p class="card-text text-muted">
                            Laporan ini disusun sebagai bentuk pertanggungjawaban kepada seluruh anggota serta pemangku kepentingan,
                            guna memastikan bahwa setiap dana yang dikelola telah dialokasikan secara efektif dan sesuai dengan kebutuhan organisasi.
                        </p>

                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            Laporan ini mencakup rincian dana yang diterima, pengeluaran program kerja, serta saldo akhir yang tersedia.
                        </div>

                        <!-- Tambahan Link -->
                        <?php if (!empty($link)) : ?>
                            <p class="mt-4">
                            <div class="card border-0 shadow-sm p-3 bg-light">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="bi bi-file-earmark-text-fill text-primary fs-3"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark">Dokumen Laporan Keuangan:</span>
                                        <?php if (strpos($link, 'drive.google.com') !== false) : ?>
                                            <!-- Jika link Google Drive (PDF) -->
                                            <a href="#" class="d-block text-primary fw-bold text-decoration-none"
                                                data-bs-toggle="modal" data-bs-target="#pdfModal">
                                                Lihat Laporan Keuangan<i class="bi bi-eye-fill"></i>
                                            </a>
                                        <?php else : ?>
                                            <!-- Jika bukan Google Drive (buka tab baru) -->
                                            <a href="<?= $link; ?>" target="_blank" class="d-block text-primary fw-bold text-decoration-none">
                                                Lihat Laporan Keuangan<i class="bi bi-box-arrow-up-right"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            </p>
                        <?php endif; ?>
                    </div>
                    <!-- Tombol Kembali -->
                    <a href="javascript:history.back()" class="btn btn-secondary mt-3">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </section>

        <!-- Modal PDF -->
        <?php if (!empty($link) && strpos($link, 'drive.google.com') !== false) : ?>
            <?php
            preg_match('/\/d\/([^\/]+)/', $link, $match);
            $file_id = $match[1] ?? '';
            ?>
            <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pdfModalLabel">Laporan Keuangan Kabinet <?= $kabinet ?></h5>
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
        <?php endif; ?>

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