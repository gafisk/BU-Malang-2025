<?php
$host = "localhost"; // Server database (biasanya localhost)
$user = "root"; // Username MySQL
$pass = ''; // Password MySQL (kosong jika pakai XAMPP)
$db   = "db_bumalang"; // Ganti dengan nama database

// Buat koneksi
$conn = mysqli_connect($host, $user, $pass, $db, 3307);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
