# TirtoPesal - Aplikasi Pemesanan Travel Kalimantan Timur

TirtoPesal Travel adalah aplikasi web berbasis PHP native dan MySQL untuk sistem pemesanan travel mobil antar kota di Kalimantan Timur. Proyek ini dikembangkan sebagai tugas UAS mata kuliah Pemrograman Web.

---

## 🧾 Daftar Isi

- [Fitur Aplikasi](#fitur-aplikasi)
- [Struktur Folder](#struktur-folder)
- [Prasyarat](#prasyarat)
- [Instalasi Cepat](#instalasi-cepat)
- [Dokumentasi Video](#dokumentasi-video)
- [Identitas Mahasiswa](#identitas-mahasiswa)

---

## 🚀 Fitur Aplikasi

- Autentikasi login (admin & pelanggan)
- Manajemen data pelanggan, mobil, tujuan, pemesanan
- Sistem pembayaran: Cash, QRIS, Transfer (dengan upload bukti)
- Cetak tiket otomatis
- Modul ulasan pelanggan
- Log aktivitas admin & pelanggan
- Laporan pemesanan & pembayaran
- Tema gelap modern (dark mode) berbasis Bootstrap 5

---

## 📁 Struktur Folder

```bash
TIRTOPESAL FINAL/
├── docs/      
│   ├── ERD.png
│   └── INSTALLATION.md              
├── sql/                    
│   └── tirtopesal.sql
├── src/                     
│   ├── admin/               
│   ├── aktivitas/           
│   ├── css/                 
│   ├── img/                
│   ├── includes/            
│   ├── jadwal/              
│   ├── laporan/             
│   ├── mobil/               
│   ├── pelanggan/           
│   ├── pembayaran/          
│   ├── pemesanan/           
│   ├── setting/            
│   ├── uploads/             
│   ├── hash.php             
│   ├── index.php           
│   ├── login.php            
│   ├── logout.php          
│   ├── proses_login.php     
│   └── register.php
└── README.md     
```
---

## 📦 Prasyarat

- PHP versi 7.4 atau lebih tinggi
- MySQL versi 5.7 atau lebih tinggi
- Web server lokal (XAMPP, Laragon, dsb.)
- Composer (jika ingin dikembangkan lebih lanjut)
- Git (opsional)

---

## ⚙️ Instalasi Cepat

1. **Clone repositori**
```bash
git clone https://github.com/pesal21/Project_UAS_PemrogramanWeb_202312013.git
```
2. **Import database**
```bash
- Buka phpMyAdmin
- Buat database baru, misalnya tirtopesal
- Import file sql/database.sql
```
3. **Konfigurasi koneksi database**
- Edit file: src/includes/koneksi.php
- Sesuaikan:
```php
$host = "localhost";
$user = "root";
$pass = "pesal";
$db   = "tirtopesal";
```
4. **Jalankan aplikasi di browser**
```ruby
http://localhost/tirtopesal/src/index.php
```
```scss
👉 Untuk langkah lengkap instalasi dan konfigurasi, lihat [INSTALLATION.md](INSTALLATION.md)
```

---

## 🗃️ Struktur Database & Relasi Tabel
Database untuk aplikasi TirtoPesal Travel dirancang untuk mendukung sistem pemesanan travel berbasis web. Berikut ini adalah penjelasan masing-masing tabel dan relasinya:
```bash
📄 1. admin
Menyimpan data akun admin yang memiliki akses untuk mengelola sistem.
id_admin (PK) – ID unik admin
username – Nama pengguna admin
password – Password terenkripsi
📄 2. pelanggan
Menyimpan data pelanggan yang melakukan pemesanan travel.
id_pelanggan (PK) – ID unik pelanggan
nama_pelanggan – Nama lengkap pelanggan
no_hp – Nomor HP
email – Alamat email
password – Password untuk login pelanggan
📄 3. mobil
Berisi informasi kendaraan yang tersedia.
id_mobil (PK) – ID mobil
nama_mobil – Nama/merk mobil
no_polisi – Nomor polisi kendaraan
kapasitas – Jumlah kursi
harga_mobil – Harga dasar mobil
📄 4. tujuan
Berisi daftar rute atau tujuan perjalanan.
id_tujuan (PK) – ID tujuan
lokasi_awal – Titik keberangkatan
lokasi_akhir – Titik tujuan akhir
📄 5. pemesanan
Mencatat data transaksi pemesanan travel oleh pelanggan.
id_pemesanan (PK)
id_pelanggan (FK) → pelanggan
id_mobil (FK) → mobil
id_tujuan (FK) → tujuan
tanggal_pemesanan – Tanggal dibuatnya pesanan
tanggal_berangkat – Tanggal keberangkatan
metode_pembayaran – cash / transfer / QRIS
status – Menunggu, Lunas, atau Dibatalkan
📄 6. pembayaran
Menyimpan bukti pembayaran dari pelanggan jika menggunakan metode non-cash.
id_pembayaran (PK)
id_pemesanan (FK) → pemesanan
bukti_pembayaran – Nama file gambar bukti
status_verifikasi – Terverifikasi / Belum
📄 7. ulasan
Mencatat ulasan atau testimoni dari pelanggan setelah menggunakan layanan.
id_ulasan (PK)
id_pelanggan (FK) → pelanggan
isi_ulasan – Isi komentar
tanggal_ulasan – Tanggal ulasan dibuat
📄 8. aktivitas_admin
Log aktivitas seluruh pengguna sistem, baik admin maupun pelanggan.
id_aktivitas (PK)
id_admin (nullable, FK) → admin
id_pelanggan (nullable, FK) → pelanggan
peran – admin / pelanggan
aktivitas – Deskripsi kegiatan (Login, Tambah Data, Edit, Hapus, dsb.)
waktu – Timestamp aktivitas
📄 9. setting
Konfigurasi aplikasi seperti nama perusahaan, alamat, dan info kontak.
id_setting (PK)
nama_aplikasi – Nama sistem
deskripsi – Informasi singkat
alamat, telepon, email, dll.
```
---
## 🔁 Relasi Antar Tabel
```bash
Satu pelanggan bisa memiliki banyak pemesanan (1:N)

Satu mobil bisa digunakan di banyak pemesanan (1:N)

Satu tujuan bisa digunakan di banyak pemesanan (1:N)

Satu pemesanan bisa memiliki satu pembayaran

Satu pelanggan bisa menulis banyak ulasan

Tabel aktivitas_admin mencatat log semua tindakan baik oleh admin maupun pelanggan
```

---


## 🌐 Link Aplikasi & Dokumentasi Video
- 🔗 Demo Aplikasi (Hosting): https://tirtopesaltravel.my.id
- 🎥 Video Demo (YouTube): https://youtu.be/JQHtHcfvWw8

---

## 👥 Fitur Detail Per Role

### 👨‍💼 Admin
```bash
- Login & logout
- CRUD data mobil, pelanggan, tujuan, jadwal, pemesanan, pembayaran
- Kelola bukti transfer
- Laporan transaksi (pemesanan & pembayaran)
- Aktivitas admin (log)
- Tema gelap otomatis
```

### 🙋 Pelanggan
```bash
- Registrasi & login akun
- Melakukan pemesanan travel
- Memilih metode pembayaran (Cash, QRIS, Transfer)
- Upload bukti pembayaran
- Melihat & mencetak tiket
- Memberikan ulasan
```

---

## 🎓 Identitas Mahasiswa

```yaml
Nama    : Faizal Darmawan
NIM     : 202312013
Proyek  : UAS Pemrograman Web
Kelas   : Teknik Informatika – Pagi
Dosen   : Ir. Abadi Nugroho. S,KOM.,M.KOM
```

---

## 📄 Dokumentasi Tambahan

- 📘 Panduan instalasi lengkap: docs/INSTALLATION.md
- 🗺️ Entity Relationship Diagram: docs/ERD.png
- 🧩 Database MySQL: sql/tirtopesal.sql

---

## 📢 Lisensi

Proyek ini dikembangkan hanya untuk keperluan akademik. Tidak untuk dikomersialkan.