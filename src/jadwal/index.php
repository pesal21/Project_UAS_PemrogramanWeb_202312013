<?php
include '../includes/koneksi.php';


// Proses tambah
if (isset($_POST['tambah'])) {
    $id_mobil = $_POST['id_mobil'];
    $id_tujuan = $_POST['id_tujuan'];
    $tanggal = $_POST['tanggal'];
    $jam = $_POST['jam'];
    $kuota = $_POST['kuota'];

    mysqli_query($koneksi, "INSERT INTO jadwal (id_mobil, id_tujuan, tanggal, jam, kuota) 
        VALUES ('$id_mobil', '$id_tujuan', '$tanggal', '$jam', '$kuota')");
    header("Location: index.php");
}

// Hapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM jadwal WHERE id_jadwal='$id'");
    header("Location: index.php");
}

// Ambil semua data jadwal
$jadwal = mysqli_query($conn, "
    SELECT jadwal.*, mobil.nama_mobil, tujuan.kota 
    FROM jadwal
    JOIN mobil ON jadwal.id_mobil = mobil.id_mobil
    JOIN tujuan ON jadwal.id_tujuan = tujuan.id_tujuan
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Jadwal Keberangkatan - TirtoPesal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body>

    <div class="w3-container w3-blue">
        <h2>Kelola Jadwal Keberangkatan</h2>
    </div>

    <div class="w3-container">
        <form class="w3-card w3-padding" method="POST">
            <label>Mobil</label>
            <select class="w3-select" name="id_mobil" required>
                <option value="" disabled selected>Pilih Mobil</option>
                <?php
                $mobil = mysqli_query($koneksi, "SELECT * FROM mobil");
                while ($m = mysqli_fetch_array($mobil)) {
                    echo "<option value='$m[id_mobil]'>$m[nama_mobil] ($m[nopol])</option>";
                }
                ?>
            </select>

            <label>Tujuan</label>
            <select class="w3-select" name="id_tujuan" required>
                <option value="" disabled selected>Pilih Tujuan</option>
                <?php
                $tujuan = mysqli_query($koneksi, "SELECT * FROM tujuan");
                while ($t = mysqli_fetch_array($tujuan)) {
                    echo "<option value='$t[id_tujuan]'>$t[kota]</option>";
                }
                ?>
            </select>

            <label>Tanggal</label>
            <input class="w3-input" type="date" name="tanggal" required>

            <label>Jam</label>
            <input class="w3-input" type="time" name="jam" required>

            <label>Kuota Kursi</label>
            <input class="w3-input" type="number" name="kuota" required>

            <button class="w3-button w3-green w3-margin-top" name="tambah">Tambah Jadwal</button>
        </form>
    </div>

    <div class="w3-container w3-margin-top">
        <table class="w3-table w3-bordered">
            <tr class="w3-blue">
                <th>No</th>
                <th>Mobil</th>
                <th>Tujuan</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Kuota</th>
                <th>Aksi</th>
            </tr>
            <?php
            $no = 1;
            while ($j = mysqli_fetch_array($jadwal)) {
                echo "<tr>
                <td>$no</td>
                <td>$j[nama_mobil]</td>
                <td>$j[kota]</td>
                <td>$j[tanggal]</td>
                <td>$j[jam]</td>
                <td>$j[kuota]</td>
                <td>
                    <a href='edit_jadwal.php?id=$j[id_jadwal]' class='w3-button w3-small w3-yellow'>Edit</a>
                    <a href='?hapus=$j[id_jadwal]' onclick=\"return confirm('Yakin hapus?')\" class='w3-button w3-small w3-red'>Hapus</a>
                </td>
            </tr>";
                $no++;
            }
            ?>
        </table>
    </div>

</body>

</html>