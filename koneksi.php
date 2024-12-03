<?php
$host = "localhost";
$dbname = "tekom2b_kasus";
$username = "root";
$password = "";

try {
    // Membuat koneksi menggunakan PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Mengatur mode kesalahan agar memberikan exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Jika koneksi berhasil
    // echo "Koneksi berhasil!";
} catch (PDOException $e) {
    // Jika koneksi gagal
    die("Gagal terhubung dengan database: " . $e->getMessage());
}
?>
