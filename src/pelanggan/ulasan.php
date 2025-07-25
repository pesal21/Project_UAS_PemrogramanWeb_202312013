<?php
include '../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_mobil = $_POST['id_mobil'];
    $id_pelanggan = $_POST['id_pelanggan'];
    $rating = $_POST['rating'];
    $isi_ulasan = mysqli_real_escape_string($conn, $_POST['isi_ulasan']);

    $query = "INSERT INTO ulasan (id_mobil, id_pelanggan, rating, isi_ulasan, tanggal_ulasan) 
              VALUES ('$id_mobil', '$id_pelanggan', '$rating', '$isi_ulasan', NOW())";

    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Gagal menyimpan ulasan.";
    }
}
