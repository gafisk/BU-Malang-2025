<?php
include '../../../connections/conn.php';
// Pastikan koneksi database sudah ada di atas

// Periksa apakah 'id' ada di URL
if (isset($_GET['id'])) {
    $id_pel_awardee = $_GET['id'];

    // Validasi ID harus berupa angka
    if (!filter_var($id_pel_awardee, FILTER_VALIDATE_INT)) {
        die("ID tidak valid!");
    }

    // Query untuk mengambil data berita berdasarkan id_pel_awardee
    $stmt = $conn->prepare("SELECT * FROM pel_awardee WHERE id_pel_awardee = ?");
    $stmt->bind_param("i", $id_pel_awardee);
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah data ditemukan
    if ($row = $result->fetch_assoc()) {
        $tahun_awardee = htmlspecialchars($row['tahun_awardee']);
        $waktu = date('l, d F Y', strtotime($row['waktu'])); // Format tanggal
        $batas_pelaporan = date('l, d F Y - h:i A', strtotime($row['batas_pelaporan'])); // Format tanggal
        $link = htmlspecialchars($row['link']);
        $narahubung = htmlspecialchars($row['narahubung']);
    } else {
        echo "<script>alert('Pengumuman tidak ditemukan!'); window.location='pelaporan-awardee.php';</script>";
        exit;
    }

    $stmt->close();
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location='pelaporan-awardee.php';</script>";
    exit;
}

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
        <!-- HTML untuk Menampilkan Detail Berita -->
        <section id="contents" class="contents section">
            <div class="container mt-4">
                <h4 class="text-primary fw-bold mb-4">
                    <i class="bi bi-megaphone-fill"></i> PELAPORAN AWARDEE BEASISWA UNGGULAN REGION MALANG TAHUN <?= $tahun_awardee ?>
                </h4>
                <p class="text-muted"><i class="bi bi-calendar"></i> <?= $waktu; ?></p>

                <div class="card p-4 shadow-sm">
                    <p class="fs-5 text-justify">
                        <i class="bi bi-info-circle-fill text-info"></i>
                        Kepada seluruh penerima <strong>Beasiswa Unggulan Tahun <?= $tahun_awardee ?></strong>,
                        kami mengimbau untuk segera melakukan pelaporan guna memperbarui data penerima Beasiswa Unggulan Region Malang Tahun 2025.
                    </p>

                    <h4 class="mt-4 text-success">
                        <i class="bi bi-file-earmark-text-fill"></i> Ketentuan Pelaporan:
                    </h4>
                    <ul class="fs-5">
                        <li><i class="bi bi-check-circle text-success"></i> Pelaporan wajib bagi seluruh awardee <strong> Beasiswa Unggulan Tahun <?= $tahun_awardee ?> </strong> </li>
                        <li><i class="bi bi-check-circle text-success"></i> Pelaporan ini diperuntukkan bagi <strong>Awardee Beasiswa Unggulan</strong> yang bekuliah di <strong> Malang </strong> </li>
                        <li><i class="bi bi-check-circle text-success"></i> Isi data diri dengan lengkap dan unggah dokumen pada Formulir Pelaporan.</li>
                        <li><i class="bi bi-hourglass-split text-warning"></i> Batas akhir pelaporan: <strong class="text-danger"><?= $batas_pelaporan ?></strong></li>
                        <li><i class="bi bi-link-45deg text-primary"></i> Formulir pelaporan:
                            <a href="<?= $link ?>" class="fw-bold text-primary" target="_blank">Klik di sini</a>
                        </li>
                    </ul>

                    <h4 class="mt-4 text-info">
                        <i class="bi bi-telephone-fill"></i> Narahubung:
                    </h4>
                    <p class="fs-5">
                        Jika ada kendala, hubungi:
                    </p>

                    <div class="d-flex align-items-center">
                        <i class="bi bi-whatsapp text-success fs-3 me-2"></i>
                        <?= ($narahubung == '-' || empty($narahubung)) ? '-' : '<a href="https://wa.me/' . formatNomorWA($narahubung) . '" target="_blank">Hubungi Disini</a>'; ?>
                    </div>

                    <div class="text-center mt-4">
                        <p class="fw-bold fs-5">Salam Hangat,</p>
                        <p class="fw-bold fs-4 text-primary">Pengurus Forum Beasiswa Unggulan Malang</p>
                    </div>

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