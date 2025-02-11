<?php
session_start();
include '../../../connections/conn.php';

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

// Cek apakah ini mode edit
$id_event = isset($_GET['id']) ? intval($_GET['id']) : 0;
$jenis = "";
$nama_event = "";
$tanggal_event = "";
$pemateri = "";
$lokasi = "";
$link_pendaftaran = "";
$link_meet = "";
$isi_berita = "";
$status = "";
$narahubung = "";

if ($id_event > 0) {
  // Ambil data berita untuk ditampilkan di form jika sedang edit
  $stmt = $conn->prepare("SELECT * FROM event WHERE id_event = ?");
  $stmt->bind_param("i", $id_event);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
    $jenis = $row['jenis'];
    $nama_event = $row['nama_event'];
    $tanggal_event = $row['tanggal_event'];
    $pemateri = $row['pemateri'];
    $lokasi = $row['lokasi'];
    $link_pendaftaran = $row['link_pendaftaran'];
    $link_meet = $row['link_meet'];
    $isi_berita = $row['isi_berita'];
    $status = $row['status'];
    $narahubung = $row['narahubung'];
  }
  $stmt->close();
}

// Proses Simpan / Edit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $jenis = trim($_POST['jenis']);
  $nama_event = trim($_POST['nama_event']);
  $tanggal_event = trim($_POST['tanggal_event']);
  $pemateri = trim($_POST['pemateri']);
  $lokasi = trim($_POST['lokasi']);
  $link_pendaftaran = trim($_POST['link_pendaftaran']);
  $link_meet = trim($_POST['link_meet']);
  $isi_berita = trim($_POST['isi_berita']);
  $status = trim($_POST['status']);
  $narahubung = trim($_POST['narahubung']);

  // Konversi format datetime-local ke MySQL DATETIME
  $tanggal_event = date("Y-m-d H:i:s", strtotime($tanggal_event));

  if (!empty($jenis) && !empty($nama_event) && !empty($tanggal_event) && !empty($pemateri) && !empty($lokasi) && !empty($link_pendaftaran) && !empty($link_meet) && !empty($isi_berita) && !empty($status) && !empty($narahubung)) {
    if ($id_event > 0) {
      // Mode Edit
      $stmt = $conn->prepare("UPDATE event SET jenis = ?, nama_event = ?, tanggal_event = ?, pemateri = ?, lokasi = ?, link_pendaftaran = ?, link_meet = ?, isi_berita = ?, status = ?, narahubung = ?, waktu = NOW() WHERE id_event = ?");
      $stmt->bind_param("ssssssssssi", $jenis, $nama_event, $tanggal_event, $pemateri, $lokasi, $link_pendaftaran, $link_meet, $isi_berita, $status, $narahubung, $id_event);
      if ($stmt->execute()) {
        $_SESSION['notif_sukses'] = "Data berhasil diperbarui!";
      } else {
        $_SESSION['notif_gagal'] = "Gagal memperbarui data.";
      }
      $stmt->close();
    } else {
      // Mode Tambah Baru
      $stmt = $conn->prepare("INSERT INTO event (waktu, jenis, nama_event, tanggal_event, pemateri, lokasi, link_pendaftaran, link_meet, isi_berita, status, narahubung) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssssssss", $jenis, $nama_event, $tanggal_event, $pemateri, $lokasi, $link_pendaftaran, $link_meet, $isi_berita, $status, $narahubung);

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

  header("Location: daftar-events.php");
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
              <h3 class="mb-0">Kelola Events</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Kelola Events
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
                <div class="card-title"><?= ($id_event > 0) ? "Edit Prestasi" : "Tambah Prestasi"; ?></div>
              </div>
              <!--end::Header-->
              <!--begin::Form-->
              <!-- Form Input & Edit -->
              <form method="POST" action="">
                <div class="card-body">

                  <div class="mb-3">
                    <label for="input_jenis" class="form-label">Jenis Event</label>
                    <select class="form-control" name="jenis" id="input_jenis" required>
                      <option value="" disabled selected>Pilih Jenis</option>
                      <option value="Daring" <?= ($jenis == "Daring") ? 'selected' : ''; ?>>Daring</option>
                      <option value="Luring" <?= ($jenis == "Luring") ? 'selected' : ''; ?>>Luring</option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label for="input_nama_event" class="form-label">Nama Events</label>
                    <input type="text" class="form-control" name="nama_event" id="input_nama_event" value="<?= htmlspecialchars($nama_event); ?>" placeholder="Nama Event ...." required />
                  </div>

                  <div class="mb-3">
                    <label for="input_tanggal_event" class="form-label">Tanggal & Waktu Event</label>
                    <input type="datetime-local" class="form-control" name="tanggal_event" id="input_tanggal_event" value="<?= htmlspecialchars($tanggal_event); ?>" required />
                  </div>

                  <div class="mb-3">
                    <label for="input_pemateri" class="form-label">Pemateri</label>
                    <input type="text" class="form-control" name="pemateri" id="input_pemateri" value="<?= htmlspecialchars($pemateri); ?>" placeholder="Nama Pemateri .... (Jika tidak ada -)" required />
                  </div>

                  <div class="mb-3">
                    <label for="input_lokasi" class="form-label">Lokasi Event</label>
                    <input type="text" class="form-control" name="lokasi" id="input_lokasi" value="<?= htmlspecialchars($lokasi); ?>" placeholder="Nama Lokasi atau Paste Link Gmaps" required />
                  </div>

                  <div class="mb-3">
                    <label for="input_link_pendaftaran" class="form-label">Link Pendaftaran</label>
                    <input type="text" class="form-control" name="link_pendaftaran" id="input_link_pendaftaran" value="<?= htmlspecialchars($link_pendaftaran); ?>" placeholder="Paste Link Google Form" required />
                  </div>

                  <div class="mb-3">
                    <label for="link_meet" class="form-label">Link Meet</label>
                    <input type="text" class="form-control" name="link_meet" id="link_meet" value="<?= htmlspecialchars($link_pendaftaran); ?>" placeholder="Paste Link Zoom atau GMeet" required />
                  </div>

                  <div class="mb-3">
                    <label for="input_berita" class="form-label">Isi Berita</label>
                    <textarea class="form-control" name="isi_berita" id="input_berita" required><?= htmlspecialchars($isi_berita); ?></textarea>
                  </div>

                  <div class="mb-3">
                    <label for="input_status" class="form-label">Status</label>
                    <select class="form-control" name="status" id="input_status" required>
                      <option value="" disabled selected>Pilih Status</option>
                      <option value="Upcoming" <?= ($status == "Upcoming") ? 'selected' : ''; ?>>Upcoming</option>
                      <option value="Completed" <?= ($status == "Completed") ? 'selected' : ''; ?>>Completed</option>
                      <option value="Canceled" <?= ($status == "Canceled") ? 'selected' : ''; ?>>Canceled</option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label for="input_narahubung" class="form-label">Narahubung</label>
                    <input type="text" class="form-control" name="narahubung" id="input_narahubung" value="<?= htmlspecialchars($narahubung); ?>" placeholder="Masukkan Nomor Wa" required />
                  </div>

                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary"><?= ($id_event > 0) ? "Update" : "Simpan"; ?></button>
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