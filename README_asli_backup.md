# LuxSkin Beauty — Laravel 12

Aplikasi toko kosmetik dengan website pelanggan dan dashboard admin terpisah menggunakan satu database MySQL.

## Fitur

- Registrasi pelanggan dan login berbasis sesi.
- Katalog, pencarian, detail produk, dan stok.
- Keranjang multi-produk: tambah, ubah jumlah, dan hapus item.
- Alamat pelanggan, checkout, ongkir, metode pembayaran.
- Metode pembayaran awal: transfer bank, virtual account, e-wallet, dan COD. Ini adalah alur pembayaran manual/demo; belum terhubung ke payment gateway atau membuat VA/QRIS sungguhan.
- Pelanggan dapat mengunggah bukti pembayaran; admin dapat melihat bukti dan mengonfirmasi pembayaran.
- Pelanggan dapat melihat status pesanan; admin dapat memperbarui status dan riwayat pesanan.
- Admin dapat mengelola produk, stok, kategori, brand, galeri, pengguna, metode pembayaran, pesanan, dan modul data toko.
- Upload satu atau beberapa gambar produk dari komputer (JPG/PNG/WEBP, maksimal 4 MB per gambar) ke `storage/app/public/products`.
- Tampilan admin terang, sederhana, kontras tinggi, dan teks hitam.

## Instalasi Windows + XAMPP

1. Ekstrak folder proyek.
2. Jalankan XAMPP: Start **Apache** dan **MySQL**.
3. Buat database bernama `e_commerce_kosmetik` di phpMyAdmin.
4. Import `database/import/e_commerce_kosmetik.sql` ke database tersebut.
5. Buka PowerShell di folder `luxskin_laravel`.
6. Jalankan:

```powershell
Copy-Item .env.example .env
composer install
php artisan key:generate
```

7. Buka `.env`, pastikan pengaturan database:

```env
APP_NAME="LuxSkin Beauty"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e_commerce_kosmetik
DB_USERNAME=root
DB_PASSWORD=
SESSION_DRIVER=file
CACHE_STORE=file
```

8. Buat akun admin awal (aman dijalankan setelah import; tidak menghapus akun/data lain):

```powershell
php artisan db:seed --class=Database\Seeders\AdminAccountSeeder
```

9. Buat link storage untuk foto upload:

```powershell
php artisan storage:link
```

10. Bersihkan cache dan jalankan server:

```powershell
php artisan optimize:clear
php artisan serve
```

## Alamat lokal

Website pelanggan: `http://127.0.0.1:8000`

Website admin: `http://admin.luxskinbeauty.test:8000`

Agar domain admin lokal dikenali Windows, buka Notepad sebagai Administrator dan tambahkan ke akhir file `C:\Windows\System32\drivers\etc\hosts`:

```text
127.0.0.1 admin.luxskinbeauty.test
```

## Akun admin awal

- Email: `admin@luxskinbeauty.test`
- Password: `Admin123!`

Segera ganti password setelah login pertama. Akun dibuat oleh seeder di atas. Seeder tidak menghapus akun admin yang sudah ada.

## Catatan pembayaran

Transfer bank, virtual account, dan e-wallet merupakan metode instruksi/manual untuk simulasi toko. Pelanggan mengunggah bukti pembayaran di halaman Pesanan. Admin memeriksa bukti lalu menekan **Konfirmasi bayar**. COD dapat dipilih sebagai pembayaran saat barang diterima. Untuk menerima pembayaran sungguhan otomatis, proyek perlu integrasi resmi ke payment gateway (misalnya Midtrans/Xendit) dan kredensial merchant milik pemilik toko.

## Catatan keamanan

- File `.env` tidak disertakan dalam arsip. Buat dari `.env.example` dan isi kredensial lokal sendiri.
- Jangan unggah `.env`, password, atau secret key ke repositori publik.
- Arsip ini tidak menyertakan `vendor`; jalankan `composer install` saat setup.
