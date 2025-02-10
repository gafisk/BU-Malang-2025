<?php
session_start();
include '../../../connections/conn.php';

// Cek apakah ini mode edit
$id_kampus_awardee = isset($_GET['id']) ? intval($_GET['id']) : 0;
$nama_kampus = "";

if ($id_kampus_awardee > 0) {
  // Ambil data berita untuk ditampilkan di form jika sedang edit
  $stmt = $conn->prepare("SELECT * FROM kampus_awardee WHERE id_kampus_awardee = ?");
  $stmt->bind_param("i", $id_kampus_awardee);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
    $nama_kampus = $row['nama_kampus'];
  }
  $stmt->close();
}

// Proses Simpan / Edit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama_kampus = trim($_POST['nama_kampus']);

  if (!empty($nama_kampus)) {
    if ($id_kampus_awardee > 0) {
      // Mode Edit (Hanya update judul dan isi, waktu tetap)
      $stmt = $conn->prepare("UPDATE kampus_awardee SET nama_kampus = ? WHERE id_kampus_awardee = ?");
      $stmt->bind_param("si", $nama_kampus, $id_kampus_awardee);
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
        $target_dir = "../../assets/assets/kampus/";
        $file_extension = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $gambar_nama = time() . "." . $file_extension;
        $target_file = $target_dir . $gambar_nama;

        if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
          $_SESSION['notif_gagal'] = "Gagal mengupload gambar.";
          header("Location: daftar-kampus-awardee.php");
          exit();
        }
      }

      $stmt = $conn->prepare("INSERT INTO kampus_awardee (nama_kampus, gambar) VALUES (?, ?)");
      $stmt->bind_param("ss", $nama_kampus, $gambar_nama);

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

  header("Location: daftar-kampus-awardee.php");
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
              <h3 class="mb-0">Kelola Kampus Awardee</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Kelola Kampus Awardee
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
                <div class="card-title"><?= ($id_kampus_awardee > 0) ? "Edit Data Kampus" : "Tambah Data Kampus"; ?></div>
              </div>
              <!--end::Header-->
              <!--begin::Form-->
              <!-- Form Input & Edit -->
              <form method="POST" action="" enctype="multipart/form-data">
                <div class="card-body">
                  <?php if ($id_kampus_awardee == 0) : ?>
                    <div class="mb-3">
                      <label for="inputgambar" class="form-label">Input Gambar (.png)</label>
                      <input type="file" class="form-control" name="gambar" id="inputgambar" accept="image/*" />
                    </div>
                  <?php endif; ?>

                  <div class="mb-3">
                    <label for="input_nama" class="form-label">Nama Kampus</label>
                    <input type="text" class="form-control" name="nama_kampus" id="input_nama" value="<?= htmlspecialchars($nama_kampus); ?>" required />
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary"><?= ($id_kampus_awardee > 0) ? "Update" : "Simpan"; ?></button>
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