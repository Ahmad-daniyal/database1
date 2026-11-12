<?php


$host = "localhost";
$user = "al";
$password = "12345";
$database = "kelas_al"; 

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

echo"well";
mysqli_set_charset($koneksi, "utf8mb4");
?>
