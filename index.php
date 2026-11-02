<?php
include "db/koneksi.php";

$query = "SELECT * FROM siswa";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Siswa</title>
</head>
<body>

    <h2>Data Siswa</h2>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Kelas</th>
        </tr>

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
        ?>

        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['kelas']; ?></td>
        </tr>

        <?php
        }
        ?>

    </table>

</body>
</html>