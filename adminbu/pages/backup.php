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

include '../../connections/conn.php'; // Koneksi database

// Nama file backup
$backup_file = "backup_" . date("Y-m-d_H-i-s") . ".sql";

// Header agar file langsung terunduh
header('Content-Type: application/sql');
header('Content-Disposition: attachment; filename="' . $backup_file . '"');

// Buffer output
$backup_sql = "";

// **1. Matikan sementara foreign key checks**
$backup_sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

// **2. Ambil semua tabel (untuk struktur terlebih dahulu)**
$tables = [];
$result = $conn->query("SHOW TABLES");
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}

// **3. Export STRUKTUR tabel lebih dulu**
foreach ($tables as $table) {
    $backup_sql .= "DROP TABLE IF EXISTS `$table`;\n";
    $create_table_query = $conn->query("SHOW CREATE TABLE `$table`")->fetch_array();
    $backup_sql .= $create_table_query[1] . ";\n\n";
}

// **4. Export DATA tabel setelah semua struktur dibuat**
foreach ($tables as $table) {
    $data = $conn->query("SELECT * FROM `$table`");
    while ($row = $data->fetch_assoc()) {
        $values = array_map([$conn, 'real_escape_string'], array_values($row));
        $backup_sql .= "INSERT INTO `$table` VALUES ('" . implode("', '", $values) . "');\n";
    }
    $backup_sql .= "\n\n";
}

// **5. Aktifkan kembali foreign key checks**
$backup_sql .= "SET FOREIGN_KEY_CHECKS=1;\n\n";

// Output langsung ke browser (file akan terunduh otomatis)
echo $backup_sql;

// Tutup koneksi
$conn->close();
exit;
