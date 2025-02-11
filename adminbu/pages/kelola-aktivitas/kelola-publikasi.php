<?php
session_start();

// Set session timeout duration (10 minutes)
$timeout_duration = 10 * 60; // 10 minutes in seconds

// Check if 'username' session is set
if (!isset($_SESSION['username'])) {
  // If the session is not set, redirect to login page
  echo "<script>
            alert('Anda Dilarang Mengakses Halaman ini!!!');
            window.location.href = '../../login.php';
          </script>";
  exit;
}

// Check if the session has expired
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
  // Session has expired, unset and destroy the session
  session_unset();  // Unset all session variables
  session_destroy();  // Destroy the session
  echo "<script>
            alert('Session Anda Telah Kadaluarsa. Silakan Login Kembali.');
            window.location.href = '../../login.php';
          </script>";
  exit;
}

include '../../../connections/conn.php';

// Cek apakah ini mode edit
$id_publikasi = isset($_GET['id']) ? intval($_GET['id']) : 0;
$judul_publikasi = "";
$kategori_publikasi = "";
$penulis = "";
$asal_univ = "";
$tahun_awardee = "";
$link_publikasi = "";

if ($id_publikasi > 0) {
  // Ambil data berita untuk ditampilkan di form jika sedang edit
  $stmt = $conn->prepare("SELECT judul_publikasi, kategori_publikasi, penulis, asal_univ, tahun_awardee, link FROM publikasi WHERE id_publikasi = ?");
  $stmt->bind_param("i", $id_publikasi);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
    $judul_publikasi = $row['judul_publikasi'];
    $kategori_publikasi = $row['kategori_publikasi'];
    $penulis = $row['penulis'];
    $asal_univ = $row['asal_univ'];
    $tahun_awardee = $row['tahun_awardee'];
    $link = $row['link'];
  }
  $stmt->close();
}

// Proses Simpan / Edit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $judul_publikasi = trim($_POST['judul_publikasi']);
  $kategori_publikasi = trim($_POST['kategori_publikasi']);
  $penulis = trim($_POST['penulis']);
  $asal_univ = trim($_POST['asal_univ']);
  $tahun_awardee = trim($_POST['tahun_awardee']);
  $link = trim($_POST['link']);

  if (!empty($judul_publikasi) && !empty($kategori_publikasi) && !empty($penulis) && !empty($asal_univ) && !empty($tahun_awardee) && !empty($link)) {
    if ($id_publikasi > 0) {
      // Mode Edit
      $stmt = $conn->prepare("UPDATE publikasi SET judul_publikasi = ?, kategori_publikasi = ?, penulis = ?, asal_univ = ?, tahun_awardee = ?, link = ?, waktu = NOW() WHERE id_publikasi = ?");
      $stmt->bind_param("ssssssi", $judul_publikasi, $kategori_publikasi, $penulis, $asal_univ, $tahun_awardee, $link, $id_publikasi);
      if ($stmt->execute()) {
        $_SESSION['notif_sukses'] = "Data berhasil diperbarui!";
      } else {
        $_SESSION['notif_gagal'] = "Gagal memperbarui data.";
      }
      $stmt->close();
    } else {
      // Mode Tambah Baru
      $stmt = $conn->prepare("INSERT INTO publikasi (waktu, judul_publikasi, kategori_publikasi, penulis, asal_univ, tahun_awardee, link) VALUES (NOW(), ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssss", $judul_publikasi, $kategori_publikasi, $penulis, $asal_univ, $tahun_awardee, $link);

      if ($stmt->execute()) {
        $_SESSION['notif_sukses'] = "Data Berhasil Disimpan.";
      } else {
        $_SESSION['notif_gagal'] = "Data Gagal Disimpan.";
      }
      $stmt->close();
    }
  } else {
    $_SESSION['notif_gagal'] = "Semua field wajib diisi.";
  }

  header("Location: daftar-publikasi.php");
  exit();
}
?>



<!doctype html>
<html lang="en">
<?php include '../../components/head.php' ?>

<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <!--begin::App Wrapper-->
  <div class="app-wrapper">
    <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
              <i class="bi bi-list"></i>
            </a>
          </li>
        </ul>
        <!--end::Start Navbar Links-->
      </div>
      <!--end::Container-->
    </nav>
    <!--end::Header-->
    <!--begin::Sidebar-->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
      <?php include '../../components/navbar.php' ?>
    </aside>
    <!--end::Sidebar-->
    <!--begin::App Main-->
    <main class="app-main">
      <!--begin::App Content Header-->
      <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Kelola Publikasi</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Kelola Publikasi
                </li>
              </ol>
            </div>
          </div>
          <!--end::Row-->
        </div>
        <!--end::Container-->
      </div>
      <!--end::App Content Header-->
      <!--begin::App Content-->
      <div class="app-content">
        <div class="container-fluid">

          <!-- Konten Disini -->
          <div class="col-md-12">
            <!--begin::Quick Example-->
            <div class="card card-primary card-outline mb-4">
              <!--begin::Header-->
              <div class="card-header">
                <div class="card-title"><?= ($id_publikasi > 0) ? "Edit Prestasi" : "Tambah Prestasi"; ?></div>
              </div>
              <!--end::Header-->
              <!--begin::Form-->
              <!-- Form Input & Edit -->
              <form method="POST" action="">
                <div class="card-body">

                  <div class="mb-3">
                    <label for="input_judul_publikasi" class="form-label">Judul Publikasi</label>
                    <input type="text" class="form-control" name="judul_publikasi" id="input_judul_publikasi" value="<?= htmlspecialchars($judul_publikasi); ?>" placeholder="Judul Publikasi" required />
                  </div>

                  <div class="mb-3">
                    <label for="input_kategori_publikasi" class="form-label">Kategori Publikasi</label>
                    <input type="text" class="form-control" name="kategori_publikasi" id="input_kategori_publikasi" value="<?= htmlspecialchars($kategori_publikasi); ?>" placeholder="Pendidikan, Sosial, Ilmu Komputer dll" required />
                  </div>

                  <div class="mb-3">
                    <label for="input_penulis" class="form-label">Penulis</label>
                    <input type="text" class="form-control" name="penulis" id="input_penulis" value="<?= htmlspecialchars($penulis); ?>" placeholder="Nama Penulis ...." required />
                  </div>

                  <div class="mb-3">
                    <label for="input_universitas" class="form-label">Asal Universitas</label>
                    <input type="text" class="form-control" name="asal_univ" id="input_universitas" value="<?= htmlspecialchars($asal_univ); ?>" placeholder="Tulis Kata Universitas (Universitas Brawijaya)" required />
                  </div>

                  <div class="mb-3">
                    <label for="input_tahun" class="form-label">Tahun Awardee</label>
                    <input type="text" class="form-control" name="tahun_awardee" id="input_tahun" value="<?= htmlspecialchars($tahun_awardee); ?>" required />
                  </div>

                  <div class="mb-3">
                    <label for="input_link" class="form-label">Link Publikasi</label>
                    <input type="url" class="form-control" name="link" id="input_link" value="<?= htmlspecialchars($link ?? ''); ?>" placeholder="Link dari Publikasi atau Doi" />
                  </div>

                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary"><?= ($id_publikasi > 0) ? "Update" : "Simpan"; ?></button>
                </div>
              </form>
              <!--end::Form-->
            </div>
            <!--end::Quick Example-->
          </div>

        </div>
        <!-- /.container-fluid -->
      </div>
      <!--end::App Content-->
    </main>
    <!--end::App Main-->
    <!--begin::Footer-->
    <footer class="app-footer">
      <!--begin::To the end-->
      <div class="float-end d-none d-sm-inline">Anything you want</div>
      <!--end::To the end-->
      <!--begin::Copyright-->
      <strong>
        Copyright &copy; 2014-2024&nbsp;
        <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
      </strong>
      All rights reserved.
      <!--end::Copyright-->
    </footer>
    <!--end::Footer-->
  </div>
  <!--end::App Wrapper-->
  <!--begin::Script-->
  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <script
    src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
    integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
    crossorigin="anonymous"></script>
  <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
  <script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
  <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
  <script src="../../../dist/js/adminlte.js"></script>
  <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
  <script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
      scrollbarTheme: 'os-theme-light',
      scrollbarAutoHide: 'leave',
      scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function() {
      const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
      if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
          scrollbars: {
            theme: Default.scrollbarTheme,
            autoHide: Default.scrollbarAutoHide,
            clickScroll: Default.scrollbarClickScroll,
          },
        });
      }
    });
  </script>
  <!--end::OverlayScrollbars Configure-->
  <!--end::Script-->
</body>
<!--end::Body-->

</html>