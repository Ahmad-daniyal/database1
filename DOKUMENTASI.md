# Dokumentasi Tugas Modul 7 Pemrograman Web

## Membuat dan Menghapus Data Menggunakan PHP dan MySQL

### 1. Tujuan

Membuat website sederhana untuk menampilkan, menambahkan, dan menghapus data siswa menggunakan PHP dan MySQLi.

### 2. Alat dan Bahan

- Laragon
- PHP
- MySQL/MariaDB
- phpMyAdmin
- Browser
- Editor kode

### 3. Struktur Folder

```text
database1/
├── index.php
├── DOKUMENTASI.md
└── db/
    ├── koneksi.php
    ├── siswa.sql
    ├── tambah.php
    └── hapus.php
```

Keterangan:

- `index.php` menampilkan data siswa dan link menuju halaman tambah/hapus.
- `db/koneksi.php` menghubungkan PHP dengan database.
- `db/siswa.sql` membuat tabel dan mengisi data contoh.
- `db/tambah.php` menampilkan form dan memproses penambahan data.
- `db/hapus.php` memproses penghapusan data.

### 4. Membuat Database dan Tabel

Buka phpMyAdmin, buat database bernama `db_sekolah`, lalu jalankan SQL berikut melalui menu **SQL** atau impor file `db/siswa.sql`.

```sql
CREATE TABLE IF NOT EXISTS siswa (
    id INT NOT NULL AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
('Citra Lestari', 'XI IPS 1'),
('Dewi Anggraini', 'XI IPS 2'),
('Eko Nugroho', 'XII TKJ 1');
    kelas VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO siswa (nama, kelas) VALUES
('Andi Pratama', 'X IPA 1'),
('Budi Santoso', 'X IPA 2'),
('Citra Lestari', 'XI IPS 1'),
('Dewi Anggraini', 'XI IPS 2'),
('Eko Nugroho', 'XII TKJ 1');
```

Penjelasan:

- `id` adalah primary key yang bertambah otomatis.
- `nama` menyimpan nama siswa.
- `kelas` menyimpan kelas siswa.
- `INSERT` mengisi data contoh untuk pengujian.

### 5. Kode Program

#### 5.1 `db/koneksi.php`

```php
<?php
mysqli_report(MYSQLI_REPORT_OFF);

$host = "localhost";
$user = "al";
$password = "12345";
$database = "kelas_al"; // Ganti menjadi "db_sekolah" saat dijalankan di Laragon

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($koneksi, "utf8mb4");
?>
```

Penjelasan:

- `$host`, `$user`, `$password`, dan `$database` menyimpan data koneksi.
- `mysqli_connect()` menghubungkan PHP dengan MySQL.
- Jika koneksi gagal, program menampilkan pesan melalui `die()`.
- `mysqli_set_charset()` mengatur karakter agar tulisan tampil dengan benar.

#### 5.2 `index.php`

```php
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
    <h1>Data Siswa</h1>

    <?php
    if (isset($_GET['status'])) {
        if ($_GET['status'] == "tambah") {
            echo "<p>Data siswa berhasil ditambahkan.</p>";
        } elseif ($_GET['status'] == "hapus") {
            echo "<p>Data siswa berhasil dihapus.</p>";
        }
    }
    ?>

    <p><a href="db/tambah.php">Tambah Siswa</a></p>

    <h2>Daftar Siswa</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Aksi</th>
        </tr>

        <?php
        while ($data = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $data['id']; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['kelas']; ?></td>
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
```

Penjelasan:

- `include "db/koneksi.php"` memanggil file koneksi.
- `SELECT * FROM siswa` mengambil semua data siswa.
- Link **Tambah Siswa** mengarah ke halaman `db/tambah.php`.
- Link **Hapus** mengirim ID menggunakan metode `GET` ke `db/hapus.php`.
- `mysqli_fetch_assoc()` mengambil data satu per satu untuk ditampilkan.

#### 5.3 `db/tambah.php`

```php
<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];

    $query = mysqli_prepare(
        $koneksi,
        "INSERT INTO siswa (nama, kelas) VALUES (?, ?)"
    );

    mysqli_stmt_bind_param($query, "ss", $nama, $kelas);
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

        <button type="submit" name="simpan">Simpan</button>
        <a href="../index.php">Batal</a>
    </form>
</body>
</html>
```

Penjelasan:

- `include "koneksi.php"` memanggil file koneksi yang ada di folder yang sama.
- Form menggunakan `method="post"` untuk mengirim data.
- `$_POST['nama']` dan `$_POST['kelas']` mengambil data dari form.
- `mysqli_prepare()` dan `mysqli_stmt_bind_param()` menyiapkan perintah `INSERT`.
- Setelah data disimpan, pengguna diarahkan kembali ke `index.php`.

#### 5.4 `db/hapus.php`

```php
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
```

Penjelasan:

- `$_GET['id']` mengambil ID dari link hapus.
- `DELETE FROM siswa WHERE id = ?` menghapus data berdasarkan ID.
- Huruf `i` pada `mysqli_stmt_bind_param()` berarti data berupa bilangan bulat.
- `ALTER TABLE siswa AUTO_INCREMENT = 1` mengatur ulang nomor ID berikutnya.
- Jika tabel masih memiliki data, MySQL memakai `MAX(id) + 1`. Jika tabel kosong, ID berikutnya kembali menjadi 1.
- Setelah data dihapus, pengguna diarahkan kembali ke halaman utama.

### 6. Cara Kerja Program

1. Pengguna membuka `index.php`.
2. Program menghubungkan PHP dengan database melalui `db/koneksi.php`.
3. Data siswa diambil menggunakan `SELECT` lalu ditampilkan dalam tabel.
4. Saat link **Tambah Siswa** diklik, pengguna berpindah ke halaman `db/tambah.php`.
5. Form diisi, lalu data dikirim dengan metode `POST` dan diproses menggunakan `INSERT`.
6. Setelah berhasil, pengguna kembali ke `index.php`.
7. Saat link **Hapus** diklik, ID dikirim dengan metode `GET` ke `db/hapus.php`.
8. `db/hapus.php` menjalankan `DELETE` lalu kembali ke `index.php`.
9. Tabel pada halaman utama menampilkan data terbaru.

### 7. Pengujian

Data awal yang digunakan:

| ID | Nama | Kelas |
|----|------|-------|
| 1 | Andi Pratama | X IPA 1 |
| 2 | Budi Santoso | X IPA 2 |
| 3 | Citra Lestari | XI IPS 1 |
| 4 | Dewi Anggraini | XI IPS 2 |
| 5 | Eko Nugroho | XII TKJ 1 |

Langkah pengujian:

1. Jalankan Laragon atau perintah berikut:

   ```bash
   php -S 127.0.0.1:8000
   ```

2. Buka `http://127.0.0.1:8000` di browser.
3. Pastikan data contoh tampil pada tabel.
4. Klik **Tambah Siswa**, lalu isi data baru, misalnya:
   - Nama: Fajar Ramadhan
   - Kelas: XII IPA 1
5. Klik **Simpan** dan pastikan kembali ke halaman utama serta data baru muncul.
6. Klik **Hapus** pada salah satu data.
7. Pastikan data tersebut hilang dari tabel dan database.

### 8. Catatan Konfigurasi Database

Tugas modul menggunakan database `db_sekolah`. Pada lingkungan pengujian ini, user MySQL yang tersedia memiliki akses ke database `kelas_al`, sehingga `db/koneksi.php` menggunakan:

```php
$database = "kelas_al";
```

Saat program dijalankan di Laragon/phpMyAdmin sesuai tugas, ubah menjadi:

```php
$database = "db_sekolah";
```

Sesuaikan juga `$user` dan `$password` dengan konfigurasi MySQL di komputer masing-masing.

### 9. Kesimpulan

Website sederhana untuk mengelola data siswa berhasil dibuat menggunakan PHP dan MySQLi. Halaman `index.php` hanya menampilkan data siswa. Penambahan data dilakukan melalui halaman `db/tambah.php`, sedangkan penghapusan data diproses melalui `db/hapus.php`. Data form dikirim menggunakan metode `POST`, sedangkan ID data yang akan dihapus dikirim menggunakan metode `GET`.
