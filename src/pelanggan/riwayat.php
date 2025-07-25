<?php
session_start();
include '../includes/koneksi.php';

if (!isset($_SESSION['pelanggan'])) {
    header("Location: login.php");
    exit;
}

$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];

$query = "SELECT p.id_pemesanan, m.nama_mobil, t.kota_asal, t.kota_tujuan, 
                 p.jumlah_penumpang, p.tanggal_berangkat, p.status 
          FROM pemesanan p 
          JOIN mobil m ON p.id_mobil = m.id_mobil 
          JOIN tujuan t ON p.id_tujuan = t.id_tujuan 
          WHERE p.id_pelanggan = '$id_pelanggan' 
          ORDER BY p.tanggal_berangkat DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan - TirtoPesal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #2c2c2c;
            color: #fff;
        }

        .navbar {
            background-color: #1c1c1c;
        }

        .navbar-brand {
            color: #8eea6d !important;
        }

        .navbar .nav-link {
            color: #8eea6d !important;
            border: 1px solid rgba(142, 234, 109, 0.4);
            border-radius: 12px;
            /* agak oval */
            padding: 6px 14px;
            margin-left: 10px;
            transition: 0.3s ease;
            background-color: transparent;
        }

        .navbar .nav-link:hover {
            background-color: rgba(142, 234, 109, 0.1);
            color: #8eea6d !important;
            border-color: #8eea6d;
        }

        .navbar-brand:hover,
        .navbar-nav .nav-link:hover {
            color: #b3ff9f !important;
        }


        .table {
            background-color: #3c3c3c;
            color: #fff;
        }

        .table th {
            background-color: #444;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #000;
        }

        .btn-outline-light {
            color: #72d84f;
            border-color: #72d84f;
        }

        .btn-outline-light:hover {
            background-color: #72d84f;
            color: #fff;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-brand img {
            vertical-align: middle;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../img/LOGO.png" alt="Logo" width="40" height="40">
                TirtoPesal Travel
            </a>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Beranda</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Riwayat Pemesanan Anda</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover rounded">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mobil</th>
                        <th>Kota Asal</th>
                        <th>Kota Tujuan</th>
                        <th>Jumlah Penumpang</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama_mobil'] ?></td>
                            <td><?= $row['kota_asal'] ?></td>
                            <td><?= $row['kota_tujuan'] ?></td>
                            <td><?= $row['jumlah_penumpang'] ?></td>
                            <td><?= date('d M Y', strtotime($row['tanggal_berangkat'])) ?></td>
                            <td>
                                <span class="badge <?= $row['status'] == 'pending' ? 'badge-warning' : 'badge-success' ?>">
                                    <?= ucfirst($row['status']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-4 d-flex justify-content-center gap-3">
            <a href="pesan.php" class="btn btn-outline-light mr-2">Pesan Lagi</a>
            <a href="dashboard.php" class="btn btn-outline-light">← Kembali</a>
        </div>
    </div>

</body>

</html>