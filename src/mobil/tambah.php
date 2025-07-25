<?php
session_start();

include '../includes/koneksi.php';
include "../includes/fungsi_log.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $kapasitas = $_POST['kapasitas'];
    $plat = $_POST['plat'];
    $harga = $_POST['harga'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $folder = '../img/' . $gambar;

    if (move_uploaded_file($tmp, $folder)) {
        mysqli_query($conn, "INSERT INTO mobil (nama_mobil, kapasitas, plat_nomor,harga, gambar) 
                             VALUES ('$nama', '$kapasitas', '$plat','$harga', '$gambar')");
        header("Location: index.php");
    } else {
        echo "<script>alert('Gagal upload gambar!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }

        .navbar {
            background-color: #1f1f1f;
        }

        .navbar a.navbar-brand,
        .navbar a.nav-link,
        .navbar .dropdown-item {
            color: #8eea6d !important;
        }

        .form-label,
        .form-control {
            color: #ffffff;
        }

        .form-control {
            background-color: #2c2c2c;
            border: 1px solid #444;
        }

        .btn-success {
            background-color: #8eea6d;
            border: none;
            color: #000;
        }

        .btn-success:hover {
            background-color: #76cc5e;
        }

        .btn-secondary {
            background-color: #444;
            border: none;
        }

        .container {
            max-width: 600px;
            margin-top: 30px;
            background-color: #1e1e1e;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 10px #000;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="../pelanggan/index.php">TirtoPesal</a>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon bg-light"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../admin/index.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="../admin/mobil/">Data Mobil</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h3 class="mb-4 text-center">Tambah Mobil</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nama Mobil</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kapasitas</label>
                <input type="number" name="kapasitas" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Plat Nomor</label>
                <input type="text" name="plat" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga per Tiket (Rp)</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar Mobil</label>
                <input type="file" name="gambar" class="form-control" accept="image/*" required>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-success" type="submit">Simpan</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>