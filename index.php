<?php
include "db/koneksi.php";

$result = mysqli_query($koneksi, "SELECT * FROM siswa");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Siswa</title>
</head>
<body>
    <h1>Data Siswa XI RPL 2</h1>


    <p><a href="db/tambah.php">Tambah Siswa</a></p>

    <h2>Daftar Siswa</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>NIS</th>
            <th>Hapus</th>
        </tr>

        <?php
        while ($data = mysqli_fetch_assoc($result)) {
        ?>
                <tr>
                <td><?php echo $data['id']; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['kelas']; ?></td>
                <td><?php echo $data['jurusan']; ?></td>
                <td><?php echo $data['NIS'];?></td>
                <td>
                    <a href="db/hapus.php?id=<?php echo $data['id']; ?>">Hapus</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>
</html>
