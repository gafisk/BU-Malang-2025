<?php

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
