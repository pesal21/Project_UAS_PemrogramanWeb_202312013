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

## 🌐 Link Aplikasi & Dokumentasi Video
- 🔗 Demo Aplikasi (Hosting): https://tirtopesaltravel.my.id
- 🎥 Video Demo (YouTube): https://youtu.be/videoku

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