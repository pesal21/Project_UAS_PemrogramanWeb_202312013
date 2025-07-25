<?php
session_start();
include "../includes/koneksi.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id_pelanggan = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama   = $_POST['nama'];
    $email  = $_POST['email'];
    $no_hp  = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $password_baru = $_POST['password'];

    $sql = "UPDATE pelanggan SET 
                nama_pelanggan='$nama', 
                email='$email', 
                no_hp='$no_hp',
                alamat='$alamat'";

    if (!empty($password_baru)) {
        $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
        $sql .= ", password='$password_hash'";
    }

    $sql .= " WHERE id_pelanggan=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelanggan - TirtoPesal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Edit Data Pelanggan</h2>
        <form method="post" action="">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($data['nama_pelanggan']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Aktif</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">Nomor HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= htmlspecialchars($data['no_hp']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?= htmlspecialchars($data['alamat']) ?>">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru (kosongkan jika tidak ingin diubah)</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Isi hanya jika ingin ubah password">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>