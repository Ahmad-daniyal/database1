<?php
include "koneksi.php";

$id = $_GET['id'];

$query = mysqli_prepare(
    $koneksi,
    "DELETE FROM siswa WHERE id = ?"
);

mysqli_stmt_bind_param($query, "i", $id);
mysqli_stmt_execute($query);

mysqli_query($koneksi, "ALTER TABLE siswa AUTO_INCREMENT = 1");

header("Location: ../index.php?status=hapus");
exit;
?>
