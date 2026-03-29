***

# Laporan Proyek Website Portofolio Dinamis - Pemrograman Berbasis Web

Proyek ini adalah pengembangan dari aplikasi website portofolio sebelumnya. Website yang tadinya bersifat statis kini telah diubah menjadi **dinamis**, di mana seluruh data (profil, keahlian, pengalaman, dan sertifikat) diambil langsung dari **Database MySQL** menggunakan **PHP**, lalu dirender ke tampilan antarmuka menggunakan **Vue JS 3** dan **Bootstrap 5**.

## Identitas Mahasiswa

* **Nama:** Dharma Pala Candra
* **NIM:** 2409116065
* **Kelas:** Sistem Informasi 2024 B
* **Mata Kuliah:** Pemrograman Berbasis Web

## Teknologi yang Digunakan

1. **PHP**: Sebagai bahasa pemrograman *server-side* untuk melakukan koneksi dan *query* data dari database.
2. **MySQL 8.0**: Sebagai sistem manajemen basis data relasional (RDBMS) untuk menyimpan konten website. Dijalankan menggunakan *local environment* (Laragon).
3. **Vue JS 3 (CDN)**: Digunakan untuk merender data di sisi *client* (frontend). Menerima operan data dari PHP dalam format JSON.
4. **Bootstrap 5 (CDN)**: Digunakan untuk tata letak (*Grid System*), komponen UI yang responsif (Navbar, Card, Progress Bar).
5. **HTML5 & CSS3**: Sebagai struktur dasar dan kustomisasi tampilan tambahan.

---

## Struktur Database (MySQL)

Website ini menggunakan database bernama `tugas_pwb` yang terdiri dari 4 tabel utama:
* **`profile`**: Menyimpan data identitas utama (nama, tagline, URL gambar profil, dan deskripsi).
* **`skills`**: Menyimpan daftar keahlian beserta persentase penguasaannya (`level`).
* **`experience`**: Menyimpan riwayat pengalaman berdasarkan tahun dan judul kegiatan.
* **`certificates`**: Menyimpan data sertifikat (judul, penerbit, dan URL gambar).

---

## Penjelasan Fitur dan Implementasi Kode

### 1. Koneksi dan Pengambilan Data (PHP Backend)
Pada bagian paling atas file `index.php`, terdapat skrip PHP yang bertugas menghubungkan aplikasi ke database MySQL menggunakan ekstensi `mysqli`. Setelah terhubung, skrip melakukan *query* `SELECT` ke masing-masing tabel dan menyimpannya ke dalam variabel array PHP (seperti `$profile`, `$skills`, `$experience`, dan `$certificates`).

### 2. Jembatan Data (PHP ke Vue JS)
Ini adalah inti dari perubahan dinamis pada proyek ini. Data yang telah diambil oleh PHP dikonversi menjadi format JSON menggunakan fungsi `json_encode()`. Data JSON ini kemudian disuntikkan langsung ke dalam blok `data()` milik Vue JS agar bisa dibaca dan dirender oleh HTML.

```javascript
// Cuplikan integrasi PHP ke Vue JS pada index.php
createApp({
    data() {
        return {
            profile: <?php echo json_encode($profile); ?>,
            skills: <?php echo json_encode($skills); ?>,
            experience: <?php echo json_encode($experience); ?>,
            certificates: <?php echo json_encode($certificates); ?>
        }
    }
}).mount('#app')
```

### 3. Rendering Tampilan (Frontend)
Karena struktur data JSON yang dikirim dari PHP sama persis dengan objek statis sebelumnya, struktur HTML dan *directive* Vue JS tidak perlu banyak berubah.

* **Navbar & Home**: Data seperti `{{ profile.name }}` dan `:src="profile.image"` otomatis terisi dari tabel `profile`.
* **About Me**: Menggunakan `v-for="exp in experience"` untuk mencetak riwayat dan `:style="{ width: skill.level + '%' }"` untuk mengatur lebar *progress bar* keahlian secara reaktif berdasarkan data dari tabel `skills`.
* **Certificates**: Menggunakan *Card Layout* Bootstrap yang di-looping dengan `v-for="cert in certificates"`. Jika ada baris data sertifikat baru yang ditambahkan ke database, kartu akan otomatis bertambah di website tanpa perlu mengedit kode.

---

## Cara Menjalankan Proyek

Berbeda dengan versi statis sebelumnya, proyek ini membutuhkan *web server* lokal karena menggunakan PHP dan MySQL.

1. Pastikan Anda telah menginstal *local web environment* (direkomendasikan menggunakan **Laragon** atau XAMPP).
2. Jalankan service **Apache** dan **MySQL** pada panel kontrol web server.
3. Buka pengelola database (HeidiSQL / phpMyAdmin), lalu buat database baru dengan nama `tugas_pwb`.
4. *Import* atau jalankan *query* SQL (struktur tabel dan *insert* data) ke dalam database tersebut.
5. Pindahkan folder proyek web ini ke dalam direktori *document root*:
   * Untuk Laragon: Letakkan di `C:\laragon\www\tugas_pwb`
   * Untuk XAMPP: Letakkan di `C:\xampp\htdocs\tugas_pwb`
6. Buka browser dan ketikkan URL: `http://localhost/tugas_pwb/index.php`
7. Pastikan Anda terhubung ke internet agar aset *library* dari CDN (Vue JS & Bootstrap) dapat dimuat dengan baik.
