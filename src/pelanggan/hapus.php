<?php
session_start();
include "../includes/koneksi.php";

// Cek apakah parameter id tersedia
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Hapus data pelanggan berdasarkan ID
$query = "DELETE FROM pelanggan WHERE id = $id";
if (mysqli_query($conn, $query)) {
    header("Location: index.php");
    exit;
} else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
}
