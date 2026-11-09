CREATE TABLE IF NOT EXISTS siswa (
    id INT NOT NULL AUTO_INCREMENT primary key,
    nama VARCHAR(100) NOT NULL,
    kelas VARCHAR(50) NOT NULL,
    jurusan varchar(50) NOT NULL,
    NIS VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

