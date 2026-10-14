CREATE DATABASE IF NOT EXISTS e_commerce_kosmetik

CHARACTER SET utf8mb4

COLLATE utf8mb4_unicode_ci;

USE e_commerce_kosmetik;

CREATE TABLE users (

          id_user BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          nama VARCHAR(100) NOT NULL,

          email VARCHAR(150) NOT NULL UNIQUE,

          password VARCHAR(255) NOT NULL,

          role ENUM('admin', 'customer') NOT NULL DEFAULT 'customer',

          no_hp VARCHAR(20) NULL,

          foto VARCHAR(255) NULL,

          email_verified_at DATETIME NULL,

          remember_token VARCHAR(100) NULL,

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

                    ON UPDATE CURRENT_TIMESTAMP

) ENGINE=InnoDB;

CREATE TABLE alamat (

          id_alamat BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          id_user BIGINT UNSIGNED NOT NULL,

          label_alamat VARCHAR(50) NOT NULL DEFAULT 'Rumah',

          nama_penerima VARCHAR(100) NOT NULL,

          no_hp_penerima VARCHAR(20) NOT NULL,

          provinsi VARCHAR(100) NOT NULL,

          kota VARCHAR(100) NOT NULL,

          kecamatan VARCHAR(100) NOT NULL,

          kode_pos VARCHAR(10) NOT NULL,

          alamat_lengkap TEXT NOT NULL,

          catatan TEXT NULL,

          alamat_utama BOOLEAN NOT NULL DEFAULT FALSE,

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

                    ON UPDATE CURRENT_TIMESTAMP,

          CONSTRAINT fk_alamat_user

                    FOREIGN KEY (id_user) REFERENCES users(id_user)

                    ON UPDATE CASCADE ON DELETE CASCADE,

          INDEX idx_alamat_user (id_user)

) ENGINE=InnoDB;

CREATE TABLE kategori (

          id_kategori BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          nama_kategori VARCHAR(100) NOT NULL UNIQUE,

          slug VARCHAR(120) NOT NULL UNIQUE,

          deskripsi TEXT NULL,

          status ENUM('aktif', 'nonaktif') NOT NULL DEFAULT 'aktif',

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

                    ON UPDATE CURRENT_TIMESTAMP

) ENGINE=InnoDB;

CREATE TABLE brand (

          id_brand BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          nama_brand VARCHAR(100) NOT NULL UNIQUE,

          slug VARCHAR(120) NOT NULL UNIQUE,

          deskripsi TEXT NULL,

          logo VARCHAR(255) NULL,

          status ENUM('aktif', 'nonaktif') NOT NULL DEFAULT 'aktif',

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

                    ON UPDATE CURRENT_TIMESTAMP

) ENGINE=InnoDB;

CREATE TABLE produk (

          id_produk BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          id_kategori BIGINT UNSIGNED NOT NULL,

          id_brand BIGINT UNSIGNED NOT NULL,

          nama_produk VARCHAR(150) NOT NULL,

          slug VARCHAR(180) NOT NULL UNIQUE,

          sku VARCHAR(50) NOT NULL UNIQUE,

          deskripsi TEXT NULL,

          manfaat TEXT NULL,

          cara_pakai TEXT NULL,

          komposisi TEXT NULL,

          jenis_kulit VARCHAR(100) NULL,

          berat_gram INT UNSIGNED NOT NULL DEFAULT 0,

          harga DECIMAL(12,2) NOT NULL,

          harga_coret DECIMAL(12,2) NULL,

          status ENUM('draft', 'aktif', 'nonaktif')

                    NOT NULL DEFAULT 'draft',

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

                    ON UPDATE CURRENT_TIMESTAMP,

          CONSTRAINT fk_produk_kategori

                    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          CONSTRAINT fk_produk_brand

                    FOREIGN KEY (id_brand) REFERENCES brand(id_brand)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          CONSTRAINT chk_produk_harga CHECK (harga >= 0),

          CONSTRAINT chk_produk_harga_coret

                    CHECK (harga_coret IS NULL OR harga_coret >= 0),

          INDEX idx_produk_kategori (id_kategori),

          INDEX idx_produk_brand (id_brand),

          INDEX idx_produk_nama (nama_produk),

          INDEX idx_produk_status (status)

) ENGINE=InnoDB;

CREATE TABLE stok_produk (

          id_stok BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          id_produk BIGINT UNSIGNED NOT NULL UNIQUE,

          jumlah_stok INT UNSIGNED NOT NULL DEFAULT 0,

          stok_minimum INT UNSIGNED NOT NULL DEFAULT 0,

          updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

                    ON UPDATE CURRENT_TIMESTAMP,

          CONSTRAINT fk_stok_produk

                    FOREIGN KEY (id_produk) REFERENCES produk(id_produk)

                    ON UPDATE CASCADE ON DELETE CASCADE

) ENGINE=InnoDB;

CREATE TABLE gambar_produk (

          id_gambar BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          id_produk BIGINT UNSIGNED NOT NULL,

          path_gambar VARCHAR(255) NOT NULL,

          alt_text VARCHAR(150) NULL,

          gambar_utama BOOLEAN NOT NULL DEFAULT FALSE,

          urutan INT UNSIGNED NOT NULL DEFAULT 0,

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          CONSTRAINT fk_gambar_produk

                    FOREIGN KEY (id_produk) REFERENCES produk(id_produk)

                    ON UPDATE CASCADE ON DELETE CASCADE,

          INDEX idx_gambar_produk (id_produk)

) ENGINE=InnoDB;

CREATE TABLE keranjang (

          id_keranjang BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          id_user BIGINT UNSIGNED NOT NULL,

          status ENUM('aktif', 'checkout', 'ditinggalkan')

                    NOT NULL DEFAULT 'aktif',

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

                    ON UPDATE CURRENT_TIMESTAMP,

          CONSTRAINT fk_keranjang_user

                    FOREIGN KEY (id_user) REFERENCES users(id_user)

                    ON UPDATE CASCADE ON DELETE CASCADE,

          INDEX idx_keranjang_user_status (id_user, status)

) ENGINE=InnoDB;

CREATE TABLE detail_keranjang (

          id_detail_keranjang BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          id_keranjang BIGINT UNSIGNED NOT NULL,

          id_produk BIGINT UNSIGNED NOT NULL,

          jumlah INT UNSIGNED NOT NULL DEFAULT 1,

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

                    ON UPDATE CURRENT_TIMESTAMP,

          CONSTRAINT fk_detail_keranjang_keranjang

                    FOREIGN KEY (id_keranjang) REFERENCES keranjang(id_keranjang)

                    ON UPDATE CASCADE ON DELETE CASCADE,

          CONSTRAINT fk_detail_keranjang_produk

                    FOREIGN KEY (id_produk) REFERENCES produk(id_produk)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          CONSTRAINT uq_keranjang_produk

                    UNIQUE (id_keranjang, id_produk),

          CONSTRAINT chk_detail_keranjang_jumlah CHECK (jumlah > 0)

) ENGINE=InnoDB;

CREATE TABLE status_pesanan (

          id_status BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          kode_status VARCHAR(40) NOT NULL UNIQUE,

          nama_status VARCHAR(60) NOT NULL,

          deskripsi VARCHAR(255) NULL,

          urutan SMALLINT UNSIGNED NOT NULL DEFAULT 0

) ENGINE=InnoDB;

INSERT INTO status_pesanan

          (kode_status, nama_status, deskripsi, urutan)

VALUES

          ('menunggu_pembayaran', 'Menunggu Pembayaran', 'Pesanan menunggu pembayaran', 1),

          ('dibayar', 'Dibayar', 'Pembayaran telah dikonfirmasi', 2),

          ('diproses', 'Diproses', 'Pesanan sedang diproses', 3),

          ('dikemas', 'Dikemas', 'Pesanan sedang dikemas', 4),

          ('dikirim', 'Dikirim', 'Pesanan telah diserahkan kepada kurir', 5),

          ('selesai', 'Selesai', 'Pesanan telah selesai', 6),

          ('dibatalkan', 'Dibatalkan', 'Pesanan dibatalkan', 7),

          ('gagal', 'Gagal', 'Pesanan gagal diproses', 8);

CREATE TABLE pesanan (

          id_pesanan BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          no_invoice VARCHAR(40) NOT NULL UNIQUE,

          id_user BIGINT UNSIGNED NOT NULL,

          id_alamat BIGINT UNSIGNED NOT NULL,

          id_status BIGINT UNSIGNED NOT NULL,

          tanggal_pesanan DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

          subtotal DECIMAL(12,2) NOT NULL DEFAULT 0.00,

          diskon DECIMAL(12,2) NOT NULL DEFAULT 0.00,

          ongkir DECIMAL(12,2) NOT NULL DEFAULT 0.00,

          total_harga DECIMAL(12,2) NOT NULL DEFAULT 0.00,

          catatan_pesanan TEXT NULL,

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

                    ON UPDATE CURRENT_TIMESTAMP,

          CONSTRAINT fk_pesanan_user

                    FOREIGN KEY (id_user) REFERENCES users(id_user)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          CONSTRAINT fk_pesanan_alamat

                    FOREIGN KEY (id_alamat) REFERENCES alamat(id_alamat)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          CONSTRAINT fk_pesanan_status

                    FOREIGN KEY (id_status) REFERENCES status_pesanan(id_status)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          CONSTRAINT chk_pesanan_subtotal CHECK (subtotal >= 0),

          CONSTRAINT chk_pesanan_diskon CHECK (diskon >= 0),

          CONSTRAINT chk_pesanan_ongkir CHECK (ongkir >= 0),

          CONSTRAINT chk_pesanan_total CHECK (total_harga >= 0),

          INDEX idx_pesanan_user (id_user),

          INDEX idx_pesanan_status (id_status),

          INDEX idx_pesanan_tanggal (tanggal_pesanan)

) ENGINE=InnoDB;

CREATE TABLE riwayat_status_pesanan (

          id_riwayat_status BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          id_pesanan BIGINT UNSIGNED NOT NULL,

          id_status BIGINT UNSIGNED NOT NULL,

          keterangan VARCHAR(255) NULL,

          waktu_status DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

          CONSTRAINT fk_riwayat_status_pesanan

                    FOREIGN KEY (id_pesanan) REFERENCES pesanan(id_pesanan)

                    ON UPDATE CASCADE ON DELETE CASCADE,

          CONSTRAINT fk_riwayat_status_master

                    FOREIGN KEY (id_status) REFERENCES status_pesanan(id_status)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          INDEX idx_riwayat_status_pesanan_waktu

                    (id_pesanan, waktu_status)

) ENGINE=InnoDB;

CREATE TABLE detail_pesanan (

          id_detail_pesanan BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          id_pesanan BIGINT UNSIGNED NOT NULL,

          id_produk BIGINT UNSIGNED NOT NULL,

          nama_produk_saat_beli VARCHAR(150) NOT NULL,

          sku_saat_beli VARCHAR(50) NOT NULL,

          jumlah INT UNSIGNED NOT NULL,

          harga_satuan DECIMAL(12,2) NOT NULL,

          subtotal DECIMAL(12,2) NOT NULL,

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          CONSTRAINT fk_detail_pesanan_pesanan

                    FOREIGN KEY (id_pesanan) REFERENCES pesanan(id_pesanan)

                    ON UPDATE CASCADE ON DELETE CASCADE,

          CONSTRAINT fk_detail_pesanan_produk

                    FOREIGN KEY (id_produk) REFERENCES produk(id_produk)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          CONSTRAINT chk_detail_pesanan_jumlah CHECK (jumlah > 0),

          CONSTRAINT chk_detail_pesanan_harga CHECK (harga_satuan >= 0),

          CONSTRAINT chk_detail_pesanan_subtotal CHECK (subtotal >= 0),

          INDEX idx_detail_pesanan_pesanan (id_pesanan),

          INDEX idx_detail_pesanan_produk (id_produk)

) ENGINE=InnoDB;

CREATE TABLE metode_pembayaran (

          id_metode BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          nama_metode VARCHAR(80) NOT NULL,

          jenis_metode ENUM(

                    'transfer_bank',

                    'virtual_account',

                    'e_wallet',

                    'cod'

          ) NOT NULL,

          instruksi TEXT NULL,

          status ENUM('aktif', 'nonaktif') NOT NULL DEFAULT 'aktif',

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

                    ON UPDATE CURRENT_TIMESTAMP

) ENGINE=InnoDB;

INSERT INTO metode_pembayaran

          (nama_metode, jenis_metode, instruksi)

VALUES

          ('Transfer Bank', 'transfer_bank', 'Ikuti instruksi transfer yang ditampilkan saat checkout.'),

          ('Virtual Account', 'virtual_account', 'Gunakan nomor virtual account yang diberikan.'),

          ('E-Wallet', 'e_wallet', 'Ikuti instruksi pembayaran e-wallet.'),

          ('COD', 'cod', 'Pembayaran dilakukan saat pesanan diterima.');

CREATE TABLE pembayaran (

          id_pembayaran BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          id_pesanan BIGINT UNSIGNED NOT NULL,

          id_metode BIGINT UNSIGNED NOT NULL,

          nomor_referensi VARCHAR(100) NULL UNIQUE,

          jumlah_bayar DECIMAL(12,2) NOT NULL,

          status_pembayaran ENUM(

                    'menunggu',

                    'berhasil',

                    'gagal',

                    'kedaluwarsa',

                    'dikembalikan'

          ) NOT NULL DEFAULT 'menunggu',

          waktu_bayar DATETIME NULL,

          bukti_pembayaran VARCHAR(255) NULL,

          catatan TEXT NULL,

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

                    ON UPDATE CURRENT_TIMESTAMP,

          CONSTRAINT fk_pembayaran_pesanan

                    FOREIGN KEY (id_pesanan) REFERENCES pesanan(id_pesanan)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          CONSTRAINT fk_pembayaran_metode

                    FOREIGN KEY (id_metode) REFERENCES metode_pembayaran(id_metode)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          CONSTRAINT chk_pembayaran_jumlah CHECK (jumlah_bayar >= 0),

          INDEX idx_pembayaran_pesanan (id_pesanan),

          INDEX idx_pembayaran_status (status_pembayaran)

) ENGINE=InnoDB;

CREATE TABLE kurir (

          id_kurir BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          nama_kurir VARCHAR(80) NOT NULL UNIQUE,

          kode_kurir VARCHAR(30) NOT NULL UNIQUE,

          layanan VARCHAR(100) NULL,

          status ENUM('aktif', 'nonaktif') NOT NULL DEFAULT 'aktif',

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

                    ON UPDATE CURRENT_TIMESTAMP

) ENGINE=InnoDB;

INSERT INTO kurir (nama_kurir, kode_kurir)

VALUES

          ('JNE', 'JNE'),

          ('J&T Express', 'JNT'),

          ('SiCepat', 'SICEPAT'),

          ('AnterAja', 'ANTERAJA');

CREATE TABLE pengiriman (

          id_pengiriman BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          id_pesanan BIGINT UNSIGNED NOT NULL UNIQUE,

          id_kurir BIGINT UNSIGNED NOT NULL,

          nomor_resi VARCHAR(100) NULL UNIQUE,

          biaya_pengiriman DECIMAL(12,2) NOT NULL DEFAULT 0.00,

          status_pengiriman ENUM(

                    'menunggu',

                    'diproses',

                    'dikirim',

                    'dalam_perjalanan',

                    'diantar',

                    'diterima',

                    'gagal'

          ) NOT NULL DEFAULT 'menunggu',

          tanggal_dikirim DATETIME NULL,

          estimasi_tiba DATETIME NULL,

          tanggal_diterima DATETIME NULL,

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

                    ON UPDATE CURRENT_TIMESTAMP,

          CONSTRAINT fk_pengiriman_pesanan

                    FOREIGN KEY (id_pesanan) REFERENCES pesanan(id_pesanan)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          CONSTRAINT fk_pengiriman_kurir

                    FOREIGN KEY (id_kurir) REFERENCES kurir(id_kurir)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          CONSTRAINT chk_pengiriman_biaya CHECK (biaya_pengiriman >= 0),

          INDEX idx_pengiriman_status (status_pengiriman)

) ENGINE=InnoDB;

CREATE TABLE riwayat_pengiriman (

          id_riwayat_pengiriman BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          id_pengiriman BIGINT UNSIGNED NOT NULL,

          status_pengiriman VARCHAR(50) NOT NULL,

          lokasi VARCHAR(150) NULL,

          keterangan TEXT NULL,

          waktu_update DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

          CONSTRAINT fk_riwayat_pengiriman

                    FOREIGN KEY (id_pengiriman) REFERENCES pengiriman(id_pengiriman)

                    ON UPDATE CASCADE ON DELETE CASCADE,

          INDEX idx_riwayat_pengiriman_waktu

                    (id_pengiriman, waktu_update)

) ENGINE=InnoDB;

CREATE TABLE ulasan_produk (

          id_ulasan BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          id_user BIGINT UNSIGNED NOT NULL,

          id_produk BIGINT UNSIGNED NOT NULL,

          id_detail_pesanan BIGINT UNSIGNED NOT NULL UNIQUE,

          rating TINYINT UNSIGNED NOT NULL,

          komentar TEXT NULL,

          status ENUM('menunggu', 'ditampilkan', 'disembunyikan')

                    NOT NULL DEFAULT 'menunggu',

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

                    ON UPDATE CURRENT_TIMESTAMP,

          CONSTRAINT fk_ulasan_user

                    FOREIGN KEY (id_user) REFERENCES users(id_user)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          CONSTRAINT fk_ulasan_produk

                    FOREIGN KEY (id_produk) REFERENCES produk(id_produk)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          CONSTRAINT fk_ulasan_detail_pesanan

                    FOREIGN KEY (id_detail_pesanan)

                    REFERENCES detail_pesanan(id_detail_pesanan)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          CONSTRAINT chk_ulasan_rating CHECK (rating BETWEEN 1 AND 5),

          INDEX idx_ulasan_produk (id_produk),

          INDEX idx_ulasan_user (id_user)

) ENGINE=InnoDB;

CREATE TABLE wishlist (

          id_wishlist BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          id_user BIGINT UNSIGNED NOT NULL,

          id_produk BIGINT UNSIGNED NOT NULL,

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          CONSTRAINT fk_wishlist_user

                    FOREIGN KEY (id_user) REFERENCES users(id_user)

                    ON UPDATE CASCADE ON DELETE CASCADE,

          CONSTRAINT fk_wishlist_produk

                    FOREIGN KEY (id_produk) REFERENCES produk(id_produk)

                    ON UPDATE CASCADE ON DELETE CASCADE,

          CONSTRAINT uq_wishlist_user_produk UNIQUE (id_user, id_produk)

) ENGINE=InnoDB;

CREATE TABLE voucher (

          id_voucher BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          kode_voucher VARCHAR(40) NOT NULL UNIQUE,

          nama_voucher VARCHAR(100) NOT NULL,

          deskripsi TEXT NULL,

          jenis_diskon ENUM('persen', 'nominal') NOT NULL,

          nilai_diskon DECIMAL(12,2) NOT NULL,

          minimal_pembelian DECIMAL(12,2) NOT NULL DEFAULT 0.00,

          maksimal_diskon DECIMAL(12,2) NULL,

          kuota INT UNSIGNED NULL,

          mulai_berlaku DATETIME NOT NULL,

          akhir_berlaku DATETIME NOT NULL,

          status ENUM('aktif', 'nonaktif') NOT NULL DEFAULT 'aktif',

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP

                    ON UPDATE CURRENT_TIMESTAMP,

          CONSTRAINT chk_voucher_nilai CHECK (nilai_diskon > 0),

          CONSTRAINT chk_voucher_minimal CHECK (minimal_pembelian >= 0),

          CONSTRAINT chk_voucher_maksimal

                    CHECK (maksimal_diskon IS NULL OR maksimal_diskon >= 0),

          CONSTRAINT chk_voucher_tanggal CHECK (akhir_berlaku > mulai_berlaku),

          INDEX idx_voucher_status (status),

          INDEX idx_voucher_periode (mulai_berlaku, akhir_berlaku)

) ENGINE=InnoDB;

CREATE TABLE penggunaan_voucher (

          id_penggunaan_voucher BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          id_voucher BIGINT UNSIGNED NOT NULL,

          id_user BIGINT UNSIGNED NOT NULL,

          id_pesanan BIGINT UNSIGNED NOT NULL UNIQUE,

          jumlah_diskon DECIMAL(12,2) NOT NULL,

          waktu_penggunaan DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

          CONSTRAINT fk_penggunaan_voucher

                    FOREIGN KEY (id_voucher) REFERENCES voucher(id_voucher)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          CONSTRAINT fk_penggunaan_user

                    FOREIGN KEY (id_user) REFERENCES users(id_user)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          CONSTRAINT fk_penggunaan_pesanan

                    FOREIGN KEY (id_pesanan) REFERENCES pesanan(id_pesanan)

                    ON UPDATE CASCADE ON DELETE RESTRICT,

          CONSTRAINT chk_penggunaan_diskon CHECK (jumlah_diskon >= 0),

          INDEX idx_penggunaan_voucher_user (id_voucher, id_user)

) ENGINE=InnoDB;

CREATE TABLE notifikasi (

          id_notifikasi BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

          id_user BIGINT UNSIGNED NOT NULL,

          id_pesanan BIGINT UNSIGNED NULL,

          judul VARCHAR(150) NOT NULL,

          pesan TEXT NOT NULL,

          jenis_notifikasi ENUM(

                    'pesanan',

                    'pembayaran',

                    'pengiriman',

                    'promo',

                    'sistem'

          ) NOT NULL DEFAULT 'sistem',

          sudah_dibaca BOOLEAN NOT NULL DEFAULT FALSE,

          waktu_dibaca DATETIME NULL,

          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

          CONSTRAINT fk_notifikasi_user

                    FOREIGN KEY (id_user) REFERENCES users(id_user)

                    ON UPDATE CASCADE ON DELETE CASCADE,

          CONSTRAINT fk_notifikasi_pesanan

                    FOREIGN KEY (id_pesanan) REFERENCES pesanan(id_pesanan)

                    ON UPDATE CASCADE ON DELETE SET NULL,

          INDEX idx_notifikasi_user_baca (id_user, sudah_dibaca),

          INDEX idx_notifikasi_waktu (created_at)

) ENGINE=InnoDB;
