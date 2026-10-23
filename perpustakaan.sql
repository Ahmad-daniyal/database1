create database perpustakaan;

use perpustakaan;

create table buku (
    id_buku int auto_increment primary key,
    judul varchar(100),
    genre varchar(100),
    harga int;
);

insert into buku(judul, genre. harga)
value
('seporsi mie ayam sebelum mati', 'inspiratif', 120000)''
('bumi', 'fantasy', 120000),
('wowo goblok', 'fakta', 12000);

select*from buku;