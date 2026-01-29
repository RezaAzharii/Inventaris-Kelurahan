# Sistem Inventaris & Peminjaman Aset

Sistem manajemen inventaris aset kelurahan yang dibangun menggunakan **Laravel 12**. Aplikasi ini dirancang untuk mendata aset secara terorganisir, mengelola peminjaman, serta menyediakan label informasi aset berbasis QR Code dan laporan dalam format Excel.

## Fitur Utama

-   **Manajemen Aset Terpadu**: Pengelolaan data aset lengkap mulai dari Kode Barang, Identitas, Tahun Perolehan, hingga Nilai Aset.
-   **Sistem Peminjaman & Peminjam**:
    -   Pendataan data peminjam (personel/karyawan).
    -   Pencatatan riwayat peminjaman aset untuk memantau penggunaan barang.
-   **Export Laporan Excel**: Fitur untuk mengunduh seluruh data aset ke dalam format `.xlsx` untuk kebutuhan pelaporan dan arsip fisik.
-   **QR Code Informasi Aset**:
    -   Generate QR Code otomatis untuk setiap aset.
    -   Hasil scan mengarahkan ke halaman publik yang menampilkan informasi spesifikasi aset tanpa perlu login.
-   **Halaman Publik (Mobile Friendly)**: Tampilan detail aset yang dioptimalkan untuk perangkat seluler saat pemindaian di lapangan.
-   **Pencarian & Paginasi**: Navigasi data yang cepat dan efisien.

## Prasyarat (Prerequisites)

-   PHP >= 8.2 (Direkomendasikan untuk Laravel 12)
-   Composer
-   Node.js & NPM
-   MySQL

## Panduan Instalasi

1. **Clone Repository**

    ```bash
    git clone [https://github.com/RezaAzharii/Inventaris-Kelurahan-Bale-Catur.git](https://github.com/RezaAzharii/Inventaris-Kelurahan-Bale-Catur.git)
    ```

2. **Instalasi Dependensi**

    ```bash
    composer install
    npm install
    ```

3. **Konfigurasi Environment**

    ```bash
    cp .env.example .env
    php artisan key:generate

    ```

4. **Set-up Database**

   ```bash
   php artisan migrate --seed
   ```
   > **Noted:** default akun email `Admin@example.com` & password `rahasia123`, dan Sesuaikan pengaturan database pada file .env.

5. **Run Project aset frontend**

    ```bash
    npm run dev
    ```

6. **Run Project**
    ```bash
    php artisan serve
    ```
