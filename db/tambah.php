<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $NIS = $_POST['NIS'];

    $query = mysqli_prepare(
        $koneksi,
        "INSERT INTO siswa (nama, kelas, jurusan, NIS) VALUES (?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param($query, "ssss", $nama, $kelas, $jurusan, $NIS);
    mysqli_stmt_execute($query);

    header("Location: ../index.php?status=tambah");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Siswa</title>
</head>
<body>
    <h1>Tambah Siswa</h1>

    <form action="tambah.php" method="post">
        <label>Nama:</label><br>
        <input type="text" name="nama" required><br><br>

        <label>Kelas:</label><br>
        <input type="text" name="kelas" required><br><br>

        <label>jurusan:</label><br>
        <input type="text" name="jurusan" required><br><br>

        <label>NIS</label><br>
        <input type="text" name="NIS" required><br><br>
        
        <button type="submit" name="simpan">Simpan</button>
        <a href="../index.php">Batal</a>
    </form>
</body>
</html>
