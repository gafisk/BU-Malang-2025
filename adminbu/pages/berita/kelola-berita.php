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

// Update last activity timestamp
$_SESSION['last_activity'] = time();

include '../../../connections/conn.php';

// Cek apakah ini mode edit
$id_berita = isset($_GET['id']) ? intval($_GET['id']) : 0;
$judul_berita = "";
$isi_berita = "";

if ($id_berita > 0) {
  // Ambil data berita untuk ditampilkan di form jika sedang edit
  $stmt = $conn->prepare("SELECT judul_berita, isi_berita FROM berita WHERE id_berita = ?");
  $stmt->bind_param("i", $id_berita);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
    $judul_berita = $row['judul_berita'];
    $isi_berita = $row['isi_berita'];
  }
  $stmt->close();
}

// Proses Simpan / Edit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $judul_berita = trim($_POST['judul_berita']);
  $isi_berita = trim($_POST['isi_berita']);

  if (!empty($judul_berita) && !empty($isi_berita)) {
    if ($id_berita > 0) {
      // Mode Edit (Hanya update judul dan isi, waktu tetap)
      $stmt = $conn->prepare("UPDATE berita SET judul_berita = ?, isi_berita = ?, waktu = NOW() WHERE id_berita = ?");
      $stmt->bind_param("ssi", $judul_berita, $isi_berita, $id_berita);
      if ($stmt->execute()) {
        $_SESSION['notif_sukses'] = "Data berhasil diperbarui!";
      } else {
        $_SESSION['notif_gagal'] = "Gagal memperbarui data.";
      }
      $stmt->close();
    } else {
      // Mode Tambah Baru (waktu otomatis NOW())
      $gambar_nama = "";
      if (!empty($_FILES['gambar']['name'])) {
        $target_dir = "../../assets/assets/berita/";
        $file_extension = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $gambar_nama = time() . "." . $file_extension;
        $target_file = $target_dir . $gambar_nama;

        if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
          $_SESSION['notif_gagal'] = "Gagal mengupload gambar.";
          header("Location: daftar-berita.php");
          exit();
        }
      }

      $stmt = $conn->prepare("INSERT INTO berita (waktu, judul_berita, isi_berita, gambar) VALUES (NOW(), ?, ?, ?)");
      $stmt->bind_param("sss", $judul_berita, $isi_berita, $gambar_nama);

      if ($stmt->execute()) {
        $_SESSION['notif_sukses'] = "Data Berhasil Disimpan.";
      } else {
        $_SESSION['notif_gagal'] = "Data Gagal Disimpan.";
      }
      $stmt->close();
    }
  } else {
    $_SESSION['notif_gagal'] = "Judul dan Isi Berita wajib diisi.";
  }

  header("Location: daftar-berita.php");
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
              <h3 class="mb-0">Kelola Berita</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Kelola Berita
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
                <div class="card-title"><?= ($id_berita > 0) ? "Edit Berita" : "Tambah Berita"; ?></div>
              </div>
              <!--end::Header-->
              <!--begin::Form-->
              <!-- Form Input & Edit -->
              <form method="POST" action="" enctype="multipart/form-data">
                <div class="card-body">
                  <?php if ($id_berita == 0) : ?>
                    <div class="mb-3">
                      <label for="inputgambar" class="form-label">Input Gambar</label>
                      <input type="file" class="form-control" name="gambar" id="inputgambar" accept="image/*" />
                    </div>
                  <?php endif; ?>

                  <div class="mb-3">
                    <label for="inputjudul" class="form-label">Judul Berita</label>
                    <input type="text" class="form-control" name="judul_berita" id="inputjudul" value="<?= htmlspecialchars($judul_berita); ?>" required />
                  </div>

                  <div class="mb-3">
                    <label for="inputberita" class="form-label">Isi Berita</label>
                    <textarea class="form-control" name="isi_berita" id="inputberita" required><?= htmlspecialchars($isi_berita); ?></textarea>
                  </div>
                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary"><?= ($id_berita > 0) ? "Update" : "Simpan"; ?></button>
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