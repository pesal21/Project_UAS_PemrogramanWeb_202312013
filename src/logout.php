<?php
session_start();
session_destroy();
header("Location: login.php");
catatAktivitas($conn, "Logout", $_SESSION['peran'], $_SESSION['id_admin'] ?? null, $_SESSION['id_pelanggan'] ?? null);
exit();
