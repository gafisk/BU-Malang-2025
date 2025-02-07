<?php
session_start();
include '../../../connections/conn.php';

// Periksa apakah tombol submit ditekan
if (isset($_POST['simpan'])) {
  // Ambil dan bersihkan data dari form
  $judul_proker = trim($_POST['judul_proker']);
  $isi_berita = trim($_POST['isi_berita']);
  $judul_link = trim($_POST['judul_link']);
  $link = trim($_POST['link']);

  // Validasi input agar tidak kosong
  if (!empty($judul_proker) && !empty($isi_berita)) {
    // Query untuk menyimpan data ke database
    $sql = "INSERT INTO proker (waktu, judul_proker, isi_berita, judul_link, link) 
              VALUES (NOW(), ?, ?, ?, ?)";

    // Gunakan prepared statement untuk keamanan
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $judul_proker, $isi_berita, $judul_link, $link);

    // Eksekusi query dan cek hasilnya
    if ($stmt->execute()) {
      $_SESSION['notif_sukses'] = "Data Berhasil Disimpan.";
    } else {
      $_SESSION['notif_gagal'] = "Data Gagal Disimpan.";
    }

    // Tutup statement
    $stmt->close();
  } else {
    $_SESSION['notif_gagal'] = "Judul Program Kerja dan Isi Berita wajib diisi.";
  }

  // Redirect kembali ke halaman form setelah proses selesai
  header("Location: daftar-proker.php");
  exit();
}

// Tutup koneksi database
$conn->close();
?>
<!doctype html>
<html lang="en">
<?php include '../../components/head.php'; ?>
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
              <h3 class="mb-0">Kelola Program Kerja</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Kelola Program Kerja
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
                <div class="card-title">Tambah Data</div>
              </div>
              <!--end::Header-->
              <!--begin::Form-->
              <form method="POST" action="">
                <!--begin::Body-->
                <div class="card-body">
                  <div class="mb-3">
                    <label for="inputjudul" class="form-label">Judul Program Kerja</label>
                    <input type="text" class="form-control" name="judul_proker" id="inputjudul" />
                  </div>
                  <div class="mb-3">
                    <label for="inputberita" class="form-label">Isi Berita</label>
                    <textarea class="form-control" name="isi_berita" id="inputberita"></textarea>
                  </div>
                  <div class="mb-3">
                    <div class="row">
                      <div class="col-md-6">
                        <label for="judullink" class="form-label">Judul Link</label>
                        <input type="text" class="form-control" name="judul_link" id="judullink" />
                      </div>
                      <div class="col-md-6">
                        <label for="linkdrive" class="form-label">Link Google Drive</label>
                        <input type="link" class="form-control" name="link" id="linkdrive" />
                      </div>
                    </div>
                  </div>
                </div>
                <!--end::Body-->
                <!--begin::Footer-->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </div>
                <!--end::Footer-->
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