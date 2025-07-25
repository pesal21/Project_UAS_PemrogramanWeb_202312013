<?php
session_start();
include 'includes/koneksi.php';
include "includes/fungsi_log.php";

if ($_SESSION['peran'] == 'admin') {
    catatAktivitas($conn, "Login sebagai admin", "admin", $_SESSION['id_admin'], null);
} else if ($_SESSION['peran'] == 'pelanggan') {
    catatAktivitas($conn, "Login sebagai pelanggan", "pelanggan", null, $_SESSION['id_pelanggan']);
}

$username = $_POST['username'];
$password = $_POST['password'];

// Cek di tabel admin
$query_admin = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
if ($data = mysqli_fetch_assoc($query_admin)) {
    if (password_verify($password, $data['password'])) {
        $_SESSION['admin'] = $data;
        header("Location: admin/dashboard.php");
        exit;
    }
}

// Cek di tabel pelanggan
$query_pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan WHERE username = '$username'");
if ($data = mysqli_fetch_assoc($query_pelanggan)) {
    if (password_verify($password, $data['password'])) {
        $_SESSION['pelanggan'] = $data;
        header("Location: pelanggan/dashboard.php");
        exit;
    }
}

// Jika gagal
echo "<script>alert('Login gagal. Username atau password salah!'); window.location='login.php';</script>";
