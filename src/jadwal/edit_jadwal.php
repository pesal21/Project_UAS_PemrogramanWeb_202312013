<?php
include '../koneksi.php';
include '../cek_login.php';

$id = $_GET['id'];

// Ambil data jadwal berdasarkan ID
$data = mysqli_fetch_array(mysqli_query($koneksi, "
    SELECT * FROM jadwal WHERE id_jadwal='$id'
"));

// Proses update
if (isset($_POST['update'])) {
    $id_mobil = $_POST['id_mobil'];
    $id_tujuan = $_POST['id_tujuan'];
    $tanggal = $_POST['tanggal'];
    $jam = $_POST['jam'];
    $kuota = $_POST['kuota'];

    mysqli_query($koneksi, "
        UPDATE jadwal SET 
        id_mobil='$id_mobil', 
        id_tujuan='$id_tujuan',
        tanggal='$tanggal',
        jam='$jam',
        kuota='$kuota' 
        WHERE id_jadwal='$id'
    ");
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Jadwal - TirtoPesal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body>

    <div class="w3-container w3-blue">
        <h2>Edit Jadwal Keberangkatan</h2>
    </div>

    <div class="w3-container">
        <form class="w3-card w3-padding" method="POST">
            <label>Mobil</label>
            <select class="w3-select" name="id_mobil" required>
                <?php
                $mobil = mysqli_query($koneksi, "SELECT * FROM mobil");
                while ($m = mysqli_fetch_array($mobil)) {
                    $selected = $m['id_mobil'] == $data['id_mobil'] ? "selected" : "";
                    echo "<option value='$m[id_mobil]' $selected>$m[nama_mobil] ($m[nopol])</option>";
                }
                ?>
            </select>

            <label>Tujuan</label>
            <select class="w3-select" name="id_tujuan" required>
                <?php
                $tujuan = mysqli_query($koneksi, "SELECT * FROM tujuan");
                while ($t = mysqli_fetch_array($tujuan)) {
                    $selected = $t['id_tujuan'] == $data['id_tujuan'] ? "selected" : "";
                    echo "<option value='$t[id_tujuan]' $selected>$t[kota]</option>";
                }
                ?>
            </select>

            <label>Tanggal</label>
            <input class="w3-input" type="date" name="tanggal" value="<?= $data['tanggal'] ?>" required>

            <label>Jam</label>
            <input class="w3-input" type="time" name="jam" value="<?= $data['jam'] ?>" required>

            <label>Kuota Kursi</label>
            <input class="w3-input" type="number" name="kuota" value="<?= $data['kuota'] ?>" required>

            <button class="w3-button w3-green w3-margin-top" name="update">Update Jadwal</button>
            <a href="index.php" class="w3-button w3-gray w3-margin-top">Batal</a>
        </form>
    </div>

</body>

</html>