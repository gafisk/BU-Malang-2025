<?php
include '../../../connections/conn.php';
// Pastikan koneksi database sudah ada di atas

// Periksa apakah 'id' ada di URL
if (isset($_GET['id'])) {
    $id_event = $_GET['id'];

    // Validasi ID harus berupa angka
    if (!filter_var($id_event, FILTER_VALIDATE_INT)) {
        die("ID tidak valid!");
    }

    // Query untuk mengambil data berita berdasarkan id_proker
    $stmt = $conn->prepare("SELECT * FROM event WHERE id_event = ?");
    $stmt->bind_param("i", $id_event);
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah data ditemukan
    if ($row = $result->fetch_assoc()) {
        $nama_event = htmlspecialchars($row['nama_event']);
        $pemateri = htmlspecialchars($row['pemateri']);
        $lokasi = htmlspecialchars($row['lokasi']);
        $link_pendaftaran = htmlspecialchars($row['link_pendaftaran']);
        $link_meet = htmlspecialchars($row['link_meet']);
        $isi_berita = htmlspecialchars($row['isi_berita']);
        $tanggal_event = date('l, d F Y - h:i A', strtotime($row['tanggal_event'])); // Format tanggal
        $waktu = date('l, d F Y', strtotime($row['waktu'])); // Format tanggal
        $narahubung = htmlspecialchars($row['narahubung']);
    } else {
        echo "<script>alert('Berita tidak ditemukan!'); window.location='berita.php';</script>";
        exit;
    }

    $stmt->close();
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location='berita.php';</script>";
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
        <section id="contents" class="contents section">
            <div class="container mt-4">
                <h1 class="mb-3"><?= $nama_event; ?></h1>
                <p class="text-muted"><i class="bi bi-calendar"></i> <?= $waktu; ?></p>

                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h3 class="fw-bold"><i class="bi bi-megaphone-fill"></i> Pengumuman Event</h3>
                        <p class="mb-0">Jangan sampai ketinggalan acara seru ini! 🎉</p>
                    </div>
                    <div class="card-body p-4">
                        <p class="fw-bold text-primary">🌟 Halo, Sobat Event! 🌟</p>
                        <p>
                            Apa kabar? Semoga kalian semua dalam keadaan baik dan penuh semangat! Kami punya kabar gembira nih—sebuah acara menarik yang sayang banget kalau dilewatkan! Dengan senang hati, kami mengundang kalian untuk ikut serta dalam event <strong><?= $nama_event; ?></strong> 🎉.
                        </p>

                        <div class="row">
                            <div class="col-md-6">
                                <p><i class="bi bi-calendar-event text-success"></i> <strong>Tanggal & Waktu:</strong> <?= $tanggal_event; ?></p>
                                <p><i class="bi bi-geo-alt text-danger"></i> <strong>Lokasi:</strong> <?= $lokasi; ?></p>
                                <p><i class="bi bi-person-badge text-info"></i> <strong>Pemateri:</strong> <?= !empty($pemateri) ? $pemateri : 'Akan Diumumkan'; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="bi bi-box-arrow-in-right text-warning"></i><strong>Link Pendaftaran:</strong>
                                    <?= ($link_pendaftaran == '-') ? '-' : '<a href="' . htmlspecialchars($link_pendaftaran) . '" target="_blank" class="text-decoration-none">Klik di sini untuk daftar</a>'; ?>
                                </p>
                                <p><i class="bi bi-camera-video text-primary"></i> <strong>Link Meet:</strong>
                                    <?= ($link_meet == '-') ? '-' : '<a href="' . htmlspecialchars($link_meet) . '" target="_blank" class="text-decoration-none">Gabung di sini</a>'; ?>
                                </p>
                                <p><i class="bi bi-chat-square-text text-secondary"></i> <strong>Catatan Tambahan:</strong> <?= !empty($isi_berita) ? $isi_berita : '-'; ?></p>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3">
                            <i class="bi bi-lightbulb"></i> Kami berharap acara ini bisa menjadi wadah bagi kita semua untuk bertemu, berdiskusi, dan belajar bersama. Baik kamu yang ingin menambah wawasan, mencari inspirasi baru, atau sekadar ingin menikmati suasana acara yang menyenangkan, ini adalah tempat yang tepat!
                        </div>

                        <p><i class="bi bi-telephone-fill text-success"></i> <strong>Narahubung:</strong>
                            <?= ($narahubung == '-' || empty($narahubung)) ? '-' : '<a href="https://wa.me/' . formatNomorWA($narahubung) . '" target="_blank" class="text-decoration-none">Hubungi via WhatsApp</a>'; ?>
                        </p>

                        <div class="d-flex justify-content-between">
                            <a href="javascript:history.back()" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
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