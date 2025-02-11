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

// Ambil daftar divisi untuk select option
$divisi_options = [];
$result = $conn->query("SELECT id_divisi, nama_divisi FROM divisi");
while ($row = $result->fetch_assoc()) {
  $divisi_options[] = $row;
}

// Inisialisasi variabel form kosong untuk mode tambah
$id_anggota_divisi = "";
$id_divisi = "";
$nama_anggota = "";
$univ_anggota = "";
$linkedin = "";
$instagram = "";
$status = "";
$gambar_nama = "";

// Cek apakah ini mode edit
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $id_anggota_divisi = intval($_GET['id']);
  $query = $conn->prepare("SELECT * FROM anggota_divisi WHERE id_anggota_divisi = ?");
  $query->bind_param("i", $id_anggota_divisi);
  $query->execute();
  $result = $query->get_result();
  if ($row = $result->fetch_assoc()) {
    $id_divisi = $row['id_divisi'];
    $nama_anggota = $row['nama_anggota'];
    $univ_anggota = $row['univ_anggota'];
    $linkedin = $row['linkedin'];
    $instagram = $row['instagram'];
    $status = $row['status'];
    $gambar_nama = $row['gambar']; // Simpan nama gambar lama
  }
  $query->close();
}

// Proses Simpan atau Update Data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_anggota_divisi = isset($_POST['id_anggota_divisi']) ? intval($_POST['id_anggota_divisi']) : "";
  $id_divisi = intval($_POST['id_divisi']);
  $nama_anggota = trim($_POST['nama_anggota']);
  $univ_anggota = trim($_POST['univ_anggota']);
  $linkedin = trim($_POST['linkedin']);
  $instagram = trim($_POST['instagram']);
  $status = trim($_POST['status']);

  // Jika mode tambah, proses upload gambar
  if (empty($id_anggota_divisi) && !empty($_FILES['gambar']['name'])) {
    $target_dir = "../../assets/assets/pengurus/";
    $file_extension = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $gambar_nama = time() . "." . $file_extension;
    $target_file = $target_dir . $gambar_nama;

    if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
      $_SESSION['notif_gagal'] = "Gagal mengupload gambar.";
      header("Location: daftar-profil-pengurus.php");
      exit();
    }
  }

  // Validasi form
  if (!empty($id_divisi) && !empty($nama_anggota) && !empty($univ_anggota) && !empty($status)) {
    if ($id_anggota_divisi) {
      // Update Data (tidak mengubah gambar)
      $stmt = $conn->prepare("UPDATE anggota_divisi SET id_divisi=?, nama_anggota=?, univ_anggota=?, linkedin=?, instagram=?, status=? WHERE id_anggota_divisi=?");
      $stmt->bind_param("isssssi", $id_divisi, $nama_anggota, $univ_anggota, $linkedin, $instagram, $status, $id_anggota_divisi);
    } else {
      // Insert Data baru
      $stmt = $conn->prepare("INSERT INTO anggota_divisi (id_divisi, nama_anggota, univ_anggota, linkedin, instagram, gambar, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("issssss", $id_divisi, $nama_anggota, $univ_anggota, $linkedin, $instagram, $gambar_nama, $status);
    }

    if ($stmt->execute()) {
      $_SESSION['notif_sukses'] = "Data Berhasil Disimpan.";
    } else {
      $_SESSION['notif_gagal'] = "Data Gagal Disimpan.";
    }
    $stmt->close();
  } else {
    $_SESSION['notif_gagal'] = "Divisi, Nama Lengkap, Universitas, dan Status wajib diisi.";
  }

  header("Location: daftar-profil-pengurus.php");
  exit();
}

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
              <h3 class="mb-0">Kelola Profil Pengurus</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Kelola Profil Pengurus
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
              <form method="POST" action="" enctype="multipart/form-data">
                <div class="card-body">
                  <input type="hidden" name="id_anggota_divisi" value="<?= isset($id_anggota_divisi) ? $id_anggota_divisi : ''; ?>">

                  <div class="mb-3">
                    <label for="divisi" class="form-label">Divisi</label>
                    <select class="form-control" name="id_divisi" id="divisi" required>
                      <option value="">-- Pilih Divisi --</option>
                      <?php foreach ($divisi_options as $divisi) : ?>
                        <option value="<?= $divisi['id_divisi']; ?>" <?= ($id_divisi == $divisi['id_divisi']) ? 'selected' : ''; ?>>
                          <?= htmlspecialchars($divisi['nama_divisi']); ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_anggota" id="nama" value="<?= htmlspecialchars($nama_anggota ?? ''); ?>" required />
                  </div>

                  <div class="mb-3">
                    <label for="universitas" class="form-label">Universitas</label>
                    <input type="text" class="form-control" name="univ_anggota" id="universitas" value="<?= htmlspecialchars($univ_anggota ?? ''); ?>" required />
                  </div>

                  <div class="mb-3">
                    <label for="linkedin" class="form-label">LinkedIn</label>
                    <input type="url" class="form-control" name="linkedin" id="linkedin" value="<?= htmlspecialchars($linkedin ?? ''); ?>" placeholder="https://linkedin.com/in/username" />
                  </div>

                  <div class="mb-3">
                    <label for="instagram" class="form-label">Instagram</label>
                    <input type="url" class="form-control" name="instagram" id="instagram" value="<?= htmlspecialchars($instagram ?? ''); ?>" placeholder="https://instagram.com/username" />
                  </div>

                  <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" name="status" id="status" required>
                      <option value="">-- Pilih Status --</option>
                      <option value="Ketua" <?= ($status == "Ketua") ? 'selected' : ''; ?>>Ketua Umum</option>
                      <option value="Wake1" <?= ($status == "Wake1") ? 'selected' : ''; ?>>Wakil Ketua I</option>
                      <option value="Wake2" <?= ($status == "Wake2") ? 'selected' : ''; ?>>Wakil Ketua II</option>
                      <option value="Sekretaris" <?= ($status == "Sekretaris") ? 'selected' : ''; ?>>Sekretaris</option>
                      <option value="Bendahara" <?= ($status == "Bendahara") ? 'selected' : ''; ?>>Bendahara</option>
                      <option value="Koordinator" <?= ($status == "Koordinator") ? 'selected' : ''; ?>>Koordinator</option>
                      <option value="Anggota" <?= ($status == "Anggota") ? 'selected' : ''; ?>>Anggota</option>
                    </select>
                  </div>

                  <?php if (empty($id_anggota_divisi)) : ?>
                    <div class="mb-3">
                      <label for="gambar" class="form-label">Upload Foto</label>
                      <input type="file" name="gambar" class="form-control" id="gambar">
                    </div>
                  <?php endif; ?>
                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">
                    Simpan
                  </button>
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
        Copyright &copy; BU Malang 2025&nbsp;
        <a href="https://wa.me/6281939301705" class="text-decoration-none">Pengembang</a>.
      </strong>
      Jika ada Kendala
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