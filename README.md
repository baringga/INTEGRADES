# Bersih.in

![IMAGE ALT](https://github.com/mahdaf/bersihinbykel5/blob/bd0892170e3e66a0bfdf104bd40822594731426d/Logo%20Bersihin.png)

## Deskripsi Aplikasi

Bersih.in adalah aplikasi digital yang mendukung pengelolaan sampah melalui partisipasi masyarakat. Aplikasi ini hadir untuk menjawab permasalahan pengelolaan sampah di Indonesia, di mana sekitar 11,3 juta ton sampah belum tertangani setiap tahunnya. Aplikasi ini memfasilitasi kolaborasi antara komunitas, masyarakat, dan pemerintah dalam mengorganisir kampanye kebersihan. Komunitas dapat membuat dan mempublikasikan kegiatan, sementara volunteer dapat menemukan dan bergabung dalam aksi lingkungan berdasarkan lokasi, waktu, dan jenis kegiatan. Bersih.in mendorong partisipasi aktif dalam menjaga lingkungan yang bersih dan sehat.

## Fitur Aplikasi

1. **Registrasi**  
   Pengguna dapat membuat akun dengan mengisi data pribadi, seperti nama, email, dan kata sandi.

2. **Login**  
   Pengguna dapat login dengan menggunakan email dan kata sandi yang telah terdaftar.

3. **Halaman Utama**  
   Pengguna dapat melihat daftar campaign yang telah diikuti, rekomendasi campaign, dan mengakses fitur-fitur lainnya seperti pencarian campaign, lokasi, dan notifikasi.

4. **Pencarian Campaign**  
   Pengguna dapat mencari campaign berdasarkan teks atau suara, serta menggunakan filter untuk mempersempit pencarian.

5. **Campaign (Volunteer)**  
   Volunteer dapat mendaftar, menandai, menambah, dan mengedit komentar pada campaign yang tersedia.

6. **Campaign (Komunitas)**  
   Komunitas dapat membuat dan mengelola pendaftaran serta informasi detail campaign.

7. **Profil Pengguna**  
   Pengguna dapat melihat dan mengedit daftar komentar yang dipublikasikan, melihat penandaan campaign yang diminati, serta campaign yang telah didaftarkan.

8. **Profil Komunitas**  
   Komunitas dapat melihat dan mengedit campaign yang dilaksanakan, interaksi antara partisipan, komentar yang dipublikasikan, serta campaign yang telah dilaksanakan.

## Tutorial Penggunaan (Setup dan Instalasi)

Untuk menjalankan aplikasi ini secara lokal, ikuti langkah-langkah berikut:

### 1. Clone repositori ini
Jalankan perintah berikut untuk mengunduh dan masuk ke direktori proyek:
```bash
git clone https://github.com/mahdaf/bersihinbykel5.git
cd bersihinbykel5
```

### 2. Install dependencies

Instal dependensi untuk backend dan frontend proyek:

**Backend (Laravel):**
```bash
composer install
```

**Frontend (Vite + Tailwind, dsb):**
```bash
npm install
```
### 3. Salin dan Atur File Environment

Buat file `.env` dari contoh bawaan:
```bash
cp .env.example .env
```

Jalankan perintah berikut untuk generate key aplikasi Laravel:

```bash
php artisan key:generate
```

### 4. Migrasi Database dan Seed Data Awal

Sebelum menjalankan migrasi, pastikan kamu sudah membuat database baru dengan nama:
```bash
bersihin
```

Lakukan migrasi database dan isi data awal menggunakan seeder agar aplikasi dapat dijalankan dengan data dummy:

```bash
php artisan migrate:fresh --seed
```

### 5. Buat Symbolic Link untuk Penyimpanan File

Agar file upload seperti gambar dapat diakses secara publik, jalankan perintah berikut:

```bash
php artisan storage:link
```

### 6. Bangun Asset Frontend

Kompilasi frontend tailwind agar tampilan website lebih baik

**Untuk produksi:**

```bash
npm run build
```

**Untuk development:**

```bash
npm run build
```

### 7. Jalankan Server Laravel

Untuk menjalankan server lokal Laravel, gunakan perintah:

```bash
php artisan serve
```

Aplikasi akan tersedia di browser pada alamat:
```bash
http://localhost:8000
```

## 🛠️ Tech Stack

### Backend
- Laravel 10+

### Frontend
- Vite
- Tailwind CSS

### Database
- MySQL

### Others
- PHP
- Composer
- Node.js
- NPM

