<?php
session_start(); // Pastikan ini di baris pertama sebelum output apapun

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

// Proses hapus jika ada request POST dengan ID yang dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['hapus']) && isset($_POST['id_event'])) {
  $id_event = intval($_POST['id_event']);

  // Hapus data dari database
  $stmt = $conn->prepare("DELETE FROM event WHERE id_event = ?");
  $stmt->bind_param("i", $id_event);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    $_SESSION['notif_sukses'] = "Data berhasil dihapus!";
  } else {
    $_SESSION['notif_gagal'] = "Gagal menghapus data!";
  }

  $stmt->close();

  // Redirect kembali ke halaman daftar-proker.php
  header("Location: daftar-events.php");
  exit();
}

// Ambil data berita
$query = "SELECT * FROM event ORDER BY waktu DESC";
$result = $conn->query($query);
$no = 1;
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
              <h3 class="mb-0">Daftar Events</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="pages/kelola-aktivitas/kelola-events.php">Kelola Events</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Daftar Events
                </li>
              </ol>
            </div>
          </div>
          <!-- Tampilkan Notifikasi -->
          <?php if (isset($_SESSION['notif_sukses'])) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Sukses!</strong> <?= $_SESSION['notif_sukses']; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['notif_sukses']); ?>
          <?php endif; ?>

          <?php if (isset($_SESSION['notif_gagal'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Gagal!</strong> <?= $_SESSION['notif_gagal']; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['notif_gagal']); ?>
          <?php endif; ?>
          <!--end::notifikasi-->
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
            <table id="databerita" class="table table-striped" style="width:100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama Event</th>
                  <th>Jenis</th>
                  <th>Tanggal Event</th>
                  <th>Pemateri</th>
                  <th>Lokasi</th>
                  <th>Link Pendaftaran</th>
                  <th>Link Meet</th>
                  <th>Isi Berita</th>
                  <th>Narahubung</th>
                  <th>Status</th>
                  <th>Waktu Posting</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td>
                      <?php
                      $words = explode(' ', $row['nama_event']);
                      echo htmlspecialchars(implode(' ', array_slice($words, 0, 5))) . (count($words) > 5 ? '...' : '');
                      ?>
                    </td>
                    <td><?= htmlspecialchars($row['jenis']); ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($row['tanggal_event'])); ?></td>
                    <td><?= htmlspecialchars($row['pemateri']); ?></td>
                    <td><?= htmlspecialchars($row['lokasi']); ?></td>
                    <td>
                      <a href="<?= htmlspecialchars($row['link_pendaftaran']); ?>" target="_blank">
                        <?= htmlspecialchars($row['link_pendaftaran']); ?>
                      </a>
                    </td>
                    <td>
                      <a href="<?= htmlspecialchars($row['link_meet']); ?>" target="_blank">
                        <?= htmlspecialchars($row['link_meet']); ?>
                      </a>
                    </td>
                    <td>
                      <?php
                      $words = explode(' ', $row['isi_berita']);
                      echo htmlspecialchars(implode(' ', array_slice($words, 0, 5))) . (count($words) > 5 ? '...' : '');
                      ?>
                    </td>
                    <td><?= htmlspecialchars($row['narahubung']); ?></td>
                    <td><?= htmlspecialchars($row['status']); ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($row['waktu'])); ?></td>
                    <td>
                      <a href="/BU-Malang-2025/adminbu/pages/kelola-aktivitas/kelola-events.php?id=<?= $row['id_event']; ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> </a>
                      <form method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                        <input type="hidden" name="id_event" value="<?= $row['id_event']; ?>">
                        <button type="submit" name="hapus" class="btn btn-danger btn-sm">
                          <i class="bi bi-trash"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
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
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
  <script>
    new DataTable('#databerita', {
      "language": {
        "emptyTable": "Tidak ada data yang tersedia",
        "lengthMenu": "Tampilkan _MENU_ data per halaman",
        "zeroRecords": "Tidak ada data yang cocok ditemukan",
        "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        "infoEmpty": "Menampilkan 0 - 0 dari 0 data",
        "infoFiltered": "(disaring dari _MAX_ total data)",
        "search": "Cari:",
      },
      "paging": true, // Aktifkan pagination otomatis
      "searching": true, // Aktifkan fitur pencarian
      "lengthMenu": [5, 10, 25, 50, 100], // Pilihan jumlah data per halaman
      "pageLength": 10 // Default jumlah data per halaman
    });
  </script>
  <!--end::OverlayScrollbars Configure-->
  <!-- confirm delete -->
  <script>
    function confirmDelete() {
      return confirm('Yakin ingin menghapus data ini?');
    }
  </script>
  <!-- end::confirm delete -->
  <!--end::Script-->
</body>
<!--end::Body-->

</html>