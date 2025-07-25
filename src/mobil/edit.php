<?php
include '../includes/koneksi.php';
$id = $_GET['id'];
$mobil = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil = $id"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $kapasitas = $_POST['kapasitas'];
    $plat = $_POST['plat'];
    $harga = $_POST['harga'];

    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $tujuan = '../img/' . $gambar;
        move_uploaded_file($tmp, $tujuan);

        $query = "UPDATE mobil SET nama_mobil='$nama', kapasitas='$kapasitas', plat_nomor='$plat', harga='$harga', gambar='$gambar' WHERE id_mobil=$id";
    } else {
        $query = "UPDATE mobil SET nama_mobil='$nama', kapasitas='$kapasitas', plat_nomor='$plat', harga='$harga' WHERE id_mobil=$id";
    }

    mysqli_query($conn, $query);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }

        label {
            color: #8eea6d;
        }

        .form-control,
        .form-control:focus {
            background-color: #1e1e1e;
            color: #ffffff;
            border: 1px solid #8eea6d;
        }

        .btn-primary {
            background-color: #8eea6d;
            border: none;
            color: #000;
        }

        .btn-primary:hover {
            background-color: #76d659;
        }

        .btn-secondary {
            background-color: #333;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #444;
        }

        .container {
            max-width: 600px;
        }
    </style>
</head>

<body class="p-4">
    <div class="container mt-4">
        <h3 class="mb-4 text-center" style="color:#8eea6d;">Edit Data Mobil</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nama Mobil</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($mobil['nama_mobil']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Kapasitas</label>
                <input type="number" name="kapasitas" class="form-control" value="<?= $mobil['kapasitas'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Plat Nomor</label>
                <input type="text" name="plat" class="form-control" value="<?= $mobil['plat_nomor'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Harga per Tiket (Rp)</label>
                <input type="number" name="harga" class="form-control" value="<?= $mobil['harga'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Gambar Mobil (Opsional)</label><br>
                <img src="../img/<?= $mobil['gambar'] ?>" alt="Gambar Sekarang" width="150" class="mb-2 rounded"><br>
                <input type="file" name="gambar" class="form-control mt-2">
            </div>
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary">Update</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</body>

</html>