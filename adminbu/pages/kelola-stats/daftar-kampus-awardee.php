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

include '../../../connections/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['hapus']) && isset($_POST['id_kampus_awardee'])) {
  $id_kampus_awardee = intval($_POST['id_kampus_awardee']);

  // Ambil nama file gambar dari database
  $stmt = $conn->prepare("SELECT gambar FROM kampus_awardee WHERE id_kampus_awardee = ?");
  $stmt->bind_param("i", $id_kampus_awardee);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
    $gambar = $row['gambar'];

    // Hapus file gambar jika ada
    if (!empty($gambar)) {
      $file_path = $_SERVER['DOCUMENT_ROOT'] . "/BU-Malang-2025/adminbu/assets/assets/kampus/" . $gambar;
      if (file_exists($file_path)) {
        unlink($file_path); // Hapus file gambar
      }
    }
  }
  $stmt->close();

  // Hapus data berita dari database
  $stmt = $conn->prepare("DELETE FROM kampus_awardee WHERE id_kampus_awardee = ?");
  $stmt->bind_param("i", $id_kampus_awardee);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    $_SESSION['notif_sukses'] = "Data berhasil dihapus!";
  } else {
    $_SESSION['notif_gagal'] = "Gagal menghapus data!";
  }

  $stmt->close();
  $conn->close(); // Tutup koneksi database

  // Redirect kembali ke halaman utama
  header("Location: " . $_SERVER['PHP_SELF']);
  exit; // Hentikan eksekusi setelah redirect
}

// Ambil data berita
$query = "SELECT * FROM kampus_awardee";
$result = $conn->query($query);
$no = 1;

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
              <h3 class="mb-0">Daftar Kampus Awardee</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="pages/kelola-stats/kelola-kampus-awardee.php">Kelola Kampus Awardee</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Daftar Kampus Awardee
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
                  <th>Nama Kampus</th>
                  <th>Gambar</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama_kampus']); ?></td>
                    <td>
                      <?php if (!empty($row['gambar'])): ?>
                        <img src="/BU-Malang-2025/adminbu/assets/assets/kampus/<?= htmlspecialchars($row['gambar']); ?>" alt="Gambar Berita" width="100">
                      <?php else: ?>
                        <span class="text-muted">Tidak ada gambar</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <a href="/BU-Malang-2025/adminbu/pages/kelola-stats/kelola-kampus-awardee.php?id=<?= $row['id_kampus_awardee']; ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> </a>
                      <form method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                        <input type="hidden" name="id_kampus_awardee" value="<?= $row['id_kampus_awardee']; ?>">
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