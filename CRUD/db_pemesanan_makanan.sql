CREATE DATABASE IF NOT EXISTS db_pemesanan_makanan;
USE db_pemesanan_makanan;

CREATE TABLE IF NOT EXISTS makanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL,
    gambar VARCHAR(255) NOT NULL,
    kantin VARCHAR(100) NOT NULL
);

INSERT INTO makanan (nama, harga, stok, gambar, kantin) VALUES
('Nasi Goreng', 12000, 10, 'nasigoreng.jpg', 'Kantin Ibu Rika'),
('Es Teh Manis', 5000, 20, 'esteh.jpg', 'Kantin Ibu Rika'),
('Batagor', 10000, 15, 'batagor.jpg', 'Kantin Mas Riki'),
('Mie Ayam', 12000, 8, 'mieayam.jpg', 'Kantin Bu Eka');
