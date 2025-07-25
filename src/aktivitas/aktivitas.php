<?php
include "../includes/koneksi.php";
$result = mysqli_query($conn, "SELECT * FROM aktivitas_admin ORDER BY waktu DESC");
?>

<table class="table">
    <thead>
        <tr>
            <th>Waktu</th>
            <th>Peran</th>
            <th>Aktivitas</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= $row['waktu'] ?></td>
                <td><?= ucfirst($row['peran']) ?></td>
                <td><?= $row['aktivitas'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>