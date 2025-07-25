<?php
include '../includes/koneksi.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM mobil WHERE id_mobil = $id");
header("Location: index.php");
