<?php
function catatAktivitas($conn, $aktivitas, $peran, $id_admin = null, $id_pelanggan = null)
{
    $waktu = date("Y-m-d H:i:s");
    $stmt = $conn->prepare("INSERT INTO aktivitas_admin (id_admin, id_pelanggan, peran, aktivitas, waktu) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $id_admin, $id_pelanggan, $peran, $aktivitas, $waktu);
    $stmt->execute();
    $stmt->close();
}
