# Jalatrang Wisata

Platform E-Tourism untuk BUMDes Jalatrang Mandiri, Ciamis. Aplikasi ini mendukung katalog paket wisata dan cenderamata, pemesanan kunjungan, pengelolaan operasional, serta rekomendasi cross-selling berbasis algoritma Apriori.

## Fitur utama

- Katalog paket wisata dan cenderamata dengan pencarian serta filter kategori.
- Video pendukung pada setiap detail produk melalui YouTube privacy-enhanced embed yang baru dimuat setelah wisatawan memilih untuk memutar video.
- Registrasi dan autentikasi wisatawan menggunakan Laravel Breeze + Livewire Volt.
- Keranjang belanja dan checkout pemesanan tanpa payment gateway.
- Rekomendasi produk pelengkap dari aturan asosiasi Apriori.
- Panel admin untuk dashboard, manajemen produk, pesanan, parameter Apriori, dan riwayat kalkulasi.
- Hak akses berbasis peran (`admin` dan `wisatawan`) dengan Spatie Laravel Permission.
- Kalkulasi Apriori manual melalui admin/Artisan dan otomatis melalui Laravel Scheduler.
- Matriks transaksi biner 0/1 pada halaman Admin → Apriori sebagai bukti tahap prapemrosesan data.
- UI responsif yang di-build secara lokal dengan Tailwind CSS dan Vite.

## Teknologi

| Komponen | Teknologi |
| --- | --- |
| Backend | PHP 8.3+, Laravel 13 |
| UI interaktif | Livewire 3, Livewire Volt, Laravel Breeze |
| Hak akses | Spatie Laravel Permission |
| Styling | Tailwind CSS, Vite |
| Database | SQLite (default) atau MySQL 8+ |
| Pengujian | PHPUnit |

## Kebutuhan sistem

- PHP 8.3 atau lebih baru beserta ekstensi `pdo_sqlite` untuk konfigurasi default, atau `pdo_mysql` untuk MySQL.
- Composer 2.
- Node.js 20.19+ dan npm.
- Git (opsional, untuk clone proyek).

## Instalasi cepat

1. Salin/clone proyek lalu masuk ke folder proyek.

   ```bash
   cd C:\laragon\www\sideswita
   ```

2. Instal dependensi backend dan frontend.

   ```bash
   composer install
   npm install
   ```

3. Buat file konfigurasi lingkungan dan application key.

   **Windows PowerShell**

   ```powershell
   Copy-Item .env.example .env
   php artisan key:generate
   ```

   **macOS/Linux**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Pastikan database SQLite tersedia. File `database/database.sqlite` sudah disediakan. Untuk instalasi baru, buat file kosong jika belum ada.

5. Jalankan migrasi dan data demo.

   ```bash
   php artisan migrate --seed
   ```

6. Bentuk aturan rekomendasi awal dari transaksi simulasi.

   ```bash
   php artisan apriori:calculate
   ```

7. Bangun aset frontend untuk production.

   ```bash
   npm run build
   ```

   Asset visual produk sudah tersedia dalam format WebP. Bila Anda mengubah atau menambahkan gambar PNG/JPEG di `public/images/source`, konversikan kembali dengan:

   ```bash
   php artisan media:optimize
   ```

8. Jalankan aplikasi.

   ```bash
   php artisan serve
   ```

   Buka `http://127.0.0.1:8000`.

Untuk pengembangan, jalankan dua terminal terpisah:

```bash
php artisan serve
npm run dev
```

## Konfigurasi MySQL (opsional)

Buat database, misalnya `sideswita`, lalu ubah bagian database di `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sideswita
DB_USERNAME=root
DB_PASSWORD=
```

Kemudian jalankan:

```bash
php artisan migrate --seed
php artisan apriori:calculate
```

## Akun demo

Data seeder menyiapkan akun berikut:

| Peran | Email | Kata sandi |
| --- | --- | --- |
| Admin BUMDes | `admin@jalatrang.test` | `password` |
| Wisatawan | `wisatawan@jalatrang.test` | `password` |

Ganti akun/kata sandi demo sebelum aplikasi dipublikasikan.

## Apriori dan rekomendasi

Aturan association rule dibentuk dari transaksi berstatus `completed`. Aturan hanya disimpan jika memenuhi parameter berikut:

- `min_support`
- `min_confidence`
- `lift_ratio > 1`

Jalankan kalkulasi secara manual:

```bash
php artisan apriori:calculate
```

Aturan aktif dapat ditinjau dan parameter dapat diubah dari **Admin → Apriori**. Setelah data transaksi nyata tersedia, ubah status pesanan menjadi `completed`, lalu jalankan kembali kalkulasi agar rekomendasi memakai data terbaru.

Halaman yang sama menyediakan **Matriks transaksi 0/1**. Nilai `1` berarti produk muncul dalam transaksi selesai, sedangkan `0` berarti tidak muncul. Matriks tersebut merupakan bentuk data yang digunakan Apriori sebelum menghitung support, confidence, dan lift.

## Video produk

Ketiga belas produk data awal sudah memiliki video pendukung YouTube. Pada detail produk, pemain video tidak membuat request ke YouTube hingga pengunjung menekan **Putar video**, sehingga katalog dan halaman detail tetap ringan. Admin dapat mengganti sumber pada **Ruang Admin → Produk → Edit** dengan URL YouTube biasa, URL pendek, URL embed, atau ID video 11 karakter.

Daftar sumber video awal tersedia di [docs/referensi-video-produk.md](docs/referensi-video-produk.md). Tinjau relevansi dan hak penggunaan setiap sumber sebelum aplikasi dipublikasikan.

### Scheduler

Aplikasi menjadwalkan kalkulasi setiap hari pukul 01.00. Pada server production, daftarkan cron berikut:

```cron
* * * * * cd /path/to/sideswita && php artisan schedule:run >> /dev/null 2>&1
```

Untuk memantau scheduler di lingkungan lokal:

```bash
php artisan schedule:work
```

## Perintah penting

| Perintah | Kegunaan |
| --- | --- |
| `php artisan migrate --seed` | Membuat tabel dan data demo. |
| `php artisan migrate:fresh --seed` | Menghapus seluruh tabel lalu membangun ulang data demo. **Hanya untuk lokal/development.** |
| `php artisan apriori:calculate` | Menghitung ulang aturan Apriori. |
| `php artisan media:optimize` | Mengonversi PNG/JPEG pada `public/images/source` menjadi WebP teroptimasi. |
| `php artisan media:generate-product-assets` | Membuat ulang aset visual produk lokal dan WebP-nya. |
| `php artisan test` | Menjalankan test suite. |
| `npm run dev` | Menjalankan Vite development server. |
| `npm run build` | Membuat aset frontend production. |
| `php artisan optimize` | Meng-cache konfigurasi, route, dan view untuk production. |

## Struktur aplikasi

```text
app/
├── Console/Commands/CalculateApriori.php   # Perintah kalkulasi Apriori
├── Livewire/
│   ├── Storefront/                          # Katalog, detail, cart, checkout
│   └── Admin/                               # Dashboard, produk, pesanan, Apriori
├── Models/                                  # Model Eloquent
└── Services/
    ├── AprioriEngine.php                    # Mesin association rule
    └── RecommendationService.php            # Penyedia rekomendasi produk
database/
├── migrations/                              # Skema E-Tourism dan permission
└── seeders/DatabaseSeeder.php                # Akun, katalog, transaksi demo
resources/views/
├── layouts/                                 # Layout guest, aplikasi, storefront
└── livewire/                                # Tampilan Livewire
```

## Pengujian

Jalankan pengujian otomatis sebelum mengirim perubahan:

```bash
php artisan test
npm run build
```

## Catatan deployment

- Set `APP_ENV=production` dan `APP_DEBUG=false` pada `.env`.
- Jalankan `composer install --no-dev --optimize-autoloader`.
- Jalankan `npm ci && npm run build`.
- Pastikan direktori `storage` dan `bootstrap/cache` dapat ditulis oleh web server.
- Jalankan `php artisan optimize` setelah konfigurasi production selesai.
- Daftarkan Laravel Scheduler melalui cron agar rekomendasi diperbarui otomatis.
- Gunakan kredensial database dan akun admin yang kuat; jangan gunakan akun demo di production.

## Lisensi

Proyek ini dikembangkan sebagai prototipe penelitian E-Tourism Desa Jalatrang.
