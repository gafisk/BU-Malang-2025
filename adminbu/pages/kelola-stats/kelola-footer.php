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

// Ambil ID jika ada (untuk edit)
$id_footer = isset($_GET['id']) ? intval($_GET['id']) : 0;
$alamat_bu = "";
$nomor_bu = "";
$email_bu = "";
$youtube_bu = "";
$ig_bu = "";
$linkedin_bu = "";
$pengembang_bu = "";

// Jika ID ada, ambil data dari database untuk diedit
if ($id_footer > 0) {
  $stmt = $conn->prepare("SELECT * FROM footer WHERE id_footer = ?");
  $stmt->bind_param("i", $id_footer);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
    $alamat_bu = $row['alamat_bu'];
    $nomor_bu = $row['nomor_bu'];
    $email_bu = $row['email_bu'];
    $youtube_bu = $row['youtube_bu'];
    $ig_bu = $row['ig_bu'];
    $linkedin_bu = $row['linkedin_bu'];
    $pengembang_bu = $row['pengembang_bu'];
  }
  $stmt->close();
}

// Proses Simpan / Edit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $alamat_bu = trim($_POST['alamat_bu']);
  $nomor_bu = trim($_POST['nomor_bu']);
  $email_bu = trim($_POST['email_bu']);
  $youtube_bu = trim($_POST['youtube_bu']);
  $ig_bu = trim($_POST['ig_bu']);
  $linkedin_bu = trim($_POST['linkedin_bu']);
  $pengembang_bu = trim($_POST['pengembang_bu']);

  if (!empty($alamat_bu) && !empty($nomor_bu) && !empty($email_bu) && !empty($youtube_bu) && !empty($ig_bu) && !empty($linkedin_bu) && !empty($pengembang_bu)) {
    if ($id_footer > 0) {
      // Mode Edit
      $stmt = $conn->prepare("UPDATE footer SET alamat_bu = ?, nomor_bu = ?, email_bu = ?, youtube_bu = ?, ig_bu = ?, linkedin_bu = ?, pengembang_bu = ? WHERE id_footer = ?");
      $stmt->bind_param("sssssssi", $alamat_bu, $nomor_bu, $email_bu, $youtube_bu, $ig_bu, $linkedin_bu, $pengembang_bu, $id_footer);
      if ($stmt->execute()) {
        $_SESSION['notif_sukses'] = "Data berhasil diperbarui!";
      } else {
        $_SESSION['notif_gagal'] = "Gagal memperbarui data.";
      }
      $stmt->close();
    }
  } else {
    $_SESSION['notif_gagal'] = "Form wajib diisi.";
  }

  header("Location: daftar-footer.php");
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
              <h3 class="mb-0">Kelola Jumlah Awardee</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Kelola Footer
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
                <div class="card-title"><?= ($id_footer > 0) ? "Edit Data" : "Tambah Data"; ?></div>
              </div>
              <!--end::Header-->
              <!--begin::Form-->
              <form method="POST" action="">
                <div class="card-body">
                  <div class="mb-3">
                    <label for="input_alamat" class="form-label">Alamat BU Malang</label>
                    <input type="text" class="form-control" name="alamat_bu" id="input_alamat" value="<?= htmlspecialchars($alamat_bu); ?>" required />
                  </div>

                  <div class="mb-3">
                    <label for="input_nomor" class="form-label">Nomor BU Malang</label>
                    <input type="text" class="form-control" name="nomor_bu" id="input_nomor" value="<?= htmlspecialchars($nomor_bu); ?>" required />
                  </div>

                  <div class="mb-3">
                    <label for="input_email" class="form-label">Email BU Malang</label>
                    <input type="email" class="form-control" name="email_bu" id="input_email" value="<?= htmlspecialchars($email_bu); ?>" required />
                  </div>

                  <div class="mb-3">
                    <label for="input_youtube" class="form-label">Link Youtube BU Malang</label>
                    <input type="url" class="form-control" name="youtube_bu" id="input_youtube" value="<?= htmlspecialchars($youtube_bu); ?>" required />
                  </div>

                  <div class="mb-3">
                    <label for="input_ig" class="form-label">Link Instagram BU Malang</label>
                    <input type="url" class="form-control" name="ig_bu" id="input_ig" value="<?= htmlspecialchars($ig_bu); ?>" required />
                  </div>

                  <div class="mb-3">
                    <label for="input_linkedin" class="form-label">Link Linkedin BU Malang</label>
                    <input type="url" class="form-control" name="linkedin_bu" id="input_linkedin" value="<?= htmlspecialchars($linkedin_bu); ?>" required />
                  </div>

                  <div class="mb-3">
                    <label for="input_pengembang" class="form-label">Nomor WA Pengembang</label>
                    <input type="text" class="form-control" name="pengembang_bu" id="input_pengembang" value="<?= htmlspecialchars($pengembang_bu); ?>" placeholder="Pakai 6281..." required />
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary"><?= ($id_footer > 0) ? "Update" : "Simpan"; ?></button>
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