<?php
include '../includes/koneksi.php';

// Debugging: Tampilkan error jika koneksi gagal
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Query untuk mengambil data pembayaran
$sql = "
    SELECT 
        pembayaran.*, 
        pelanggan.nama_pelanggan, 
        pembayaran.metode_pembayaran, 
        pembayaran.bukti_pembayaran, 
        pembayaran.status, 
        pemesanan.id_pemesanan
    FROM pembayaran
    JOIN pemesanan ON pembayaran.id_pemesanan = pemesanan.id_pemesanan
    JOIN pelanggan ON pemesanan.id_pelanggan = pelanggan.id_pelanggan
    ORDER BY pembayaran.tanggal_pembayaran DESC";

$query = mysqli_query($conn, $sql);

// Jika query gagal, tampilkan error
if (!$query) {
    die("Query error: " . mysqli_error($conn));
}

// Tangani verifikasi pembayaran jika ada permintaan
if (isset($_GET['verify']) && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Update status pembayaran
    $update_sql = "UPDATE pembayaran SET status = 'terverifikasi' WHERE id_pembayaran = '$id'";
    if (mysqli_query($conn, $update_sql)) {
        // Update status pemesanan terkait
        $update_pemesanan = "UPDATE pemesanan SET status = 'dikonfirmasi' 
                             WHERE id_pemesanan = (
                                 SELECT id_pemesanan FROM pembayaran WHERE id_pembayaran = '$id'
                             )";
        mysqli_query($conn, $update_pemesanan);

        // Redirect untuk refresh data
        header("Location: index.php?success=1");
        exit();
    } else {
        die("Update error: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembayaran - TirtoPesal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --brand-color: #8eea6d;
            --brand-dark: #6fc554;
            --sidebar-bg: #1a1a1a;
            --card-bg: #1e1e1e;
            --card-border: #2e2e2e;
            --text-primary: #f0f0f0;
            --text-secondary: #a0a0a0;
        }

        * {
            transition: all 0.3s ease;
        }

        body {
            background-color: #121212;
            color: var(--text-primary);
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        .sidebar {
            min-height: 100vh;
            background-color: var(--sidebar-bg);
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.3);
            z-index: 100;
            position: relative;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(to bottom, var(--brand-color), transparent);
        }

        .sidebar a {
            color: var(--text-primary);
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            border-radius: 8px;
            margin: 8px 10px;
            position: relative;
            overflow: hidden;
            font-weight: 500;
        }

        .sidebar a i {
            width: 24px;
            text-align: center;
            margin-right: 12px;
        }

        .sidebar a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(142, 234, 109, 0.2), transparent);
            transition: 0.5s;
        }

        .sidebar a:hover::before {
            left: 100%;
        }

        .sidebar a:hover,
        .sidebar .active {
            background-color: rgba(142, 234, 109, 0.15);
            color: var(--brand-color);
            transform: translateX(5px);
        }

        .sidebar .active {
            box-shadow: 0 0 10px rgba(142, 234, 109, 0.2);
        }

        .sidebar hr {
            border-color: rgba(142, 234, 109, 0.3);
            margin: 20px 15px;
        }

        .sidebar .logout:hover {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .text-brand {
            color: var(--brand-color);
            font-weight: 700;
        }

        .brand-logo {
            padding: 20px 15px;
            border-bottom: 1px solid rgba(142, 234, 109, 0.2);
            margin-bottom: 15px;
        }

        .brand-logo h4 {
            position: relative;
            display: inline-block;
        }

        .brand-logo h4::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--brand-color);
            border-radius: 3px;
        }

        /* Main Content Styles */
        .main-content {
            padding: 30px;
            flex: 1;
            position: relative;
        }

        .welcome-section {
            margin-bottom: 30px;
            animation: fadeInDown 0.8s ease-out;
        }

        .card-container {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(20px);
        }

        .card-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: var(--brand-color);
        }

        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background-color: rgba(142, 234, 109, 0.1);
            color: var(--brand-color);
            font-weight: 600;
            padding: 15px 20px;
            border-bottom: 1px solid rgba(142, 234, 109, 0.2);
        }

        .table td {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            vertical-align: middle;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(142, 234, 109, 0.05);
            transform: translateX(5px);
        }

        .badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .badge.bg-success {
            background-color: rgba(40, 167, 69, 0.2) !important;
            color: #28a745;
            border: 1px solid #28a745;
        }

        .badge.bg-warning {
            background-color: rgba(255, 193, 7, 0.2) !important;
            color: #ffc107;
            border: 1px solid #ffc107;
        }

        .badge.bg-secondary {
            background-color: rgba(108, 117, 125, 0.2) !important;
            color: #6c757d;
            border: 1px solid #6c757d;
        }

        .btn-link {
            color: var(--brand-color);
            text-decoration: none;
            position: relative;
            padding-right: 20px;
        }

        .btn-link::after {
            content: '↗';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.8em;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-link:hover::after {
            opacity: 1;
        }

        .btn-link:hover {
            color: var(--brand-dark);
        }

        .text-muted {
            color: var(--text-secondary) !important;
        }

        .action-btn {
            padding: 6px 12px;
            font-size: 0.875rem;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .search-container {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .search-container .form-control {
            background: #2a2a2a;
            border: 1px solid #3a3a3a;
            color: var(--text-primary);
            flex: 1;
            min-width: 250px;
        }

        .search-container .form-select {
            background: #2a2a2a;
            border: 1px solid #3a3a3a;
            color: var(--text-primary);
            width: 200px;
        }

        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.5s ease;
        }

        .alert.show {
            opacity: 1;
            transform: translateX(0);
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeInUp 0.6s forwards;
        }

        /* Footer */
        .admin-footer {
            text-align: center;
            padding: 20px;
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }

            .sidebar a span {
                display: none;
            }

            .sidebar a i {
                margin-right: 0;
                font-size: 1.2rem;
            }

            .brand-logo h4 {
                display: none;
            }

            .brand-logo {
                height: 70px;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0;
            }

            .brand-logo::after {
                content: "TP";
                color: var(--brand-color);
                font-weight: 700;
                font-size: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .table-responsive {
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .search-container {
                flex-direction: column;
            }

            .search-container .form-control,
            .search-container .form-select {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-0">
            <div class="brand-logo">
                <h4 class="text-brand fw-bold">TirtoPesal</h4>
            </div>
            <a href="../admin/dashboard.php">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="../mobil/index.php">
                <i class="fas fa-car"></i>
                <span>Data Mobil</span>
            </a>
            <a href="../pelanggan/index.php">
                <i class="fas fa-users"></i>
                <span>Data Pelanggan</span>
            </a>
            <a href="index.php" class="active">
                <i class="fas fa-money-bill-wave"></i>
                <span>Pembayaran</span>
            </a>
            <a href="../laporan/index.php">
                <i class="fas fa-chart-bar"></i>
                <span>Laporan</span>
            </a>
            <a href="../setting/index.php">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
            <hr>
            <a href="../logout.php" class="logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="welcome-section">
                <h3 class="text-brand fw-semibold">Data Pembayaran</h3>
                <p>Kelola semua transaksi pembayaran pelanggan TirtoPesal</p>
            </div>

            <!-- Alert untuk sukses/gagal -->
            <?php if (isset($_GET['success'])) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> Pembayaran berhasil diverifikasi!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> <?= htmlspecialchars($_GET['error']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Filter dan Pencarian -->
            <div class="search-container">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari nama pelanggan atau ID pemesanan...">
                <select class="form-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="terverifikasi">Terverifikasi</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
                <select class="form-select" id="metodeFilter">
                    <option value="">Semua Metode</option>
                    <option value="transfer">Transfer</option>
                    <option value="tunai">Tunai</option>
                </select>
            </div>

            <!-- Card Container -->
            <div class="card-container fade-in">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>ID Pemesanan</th>
                                <th>Metode</th>
                                <th>Bukti</th>
                                <th>Tanggal Bayar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) :
                            ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                                        <td>#<?= $row['id_pemesanan'] ?></td>
                                        <td><?= ucfirst($row['metode_pembayaran']) ?></td>
                                        <td>
                                            <?php if (!empty($row['bukti_pembayaran'])) : ?>
                                                <a href="../uploads/<?= $row['bukti_pembayaran'] ?>" target="_blank" class="btn-link">Lihat Bukti</a>
                                            <?php else : ?>
                                                <span class="text-muted">Belum ada</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d/m/Y H:i', strtotime($row['tanggal_pembayaran'])) ?></td>
                                        <td>
                                            <?php if ($row['status'] === 'terverifikasi') : ?>
                                                <span class="badge bg-success">Terverifikasi</span>
                                            <?php elseif ($row['status'] === 'menunggu') : ?>
                                                <span class="badge bg-warning">Menunggu</span>
                                            <?php else : ?>
                                                <span class="badge bg-secondary"><?= ucfirst($row['status']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($row['status'] === 'menunggu') : ?>
                                                <a href="index.php?verify=1&id=<?= $row['id_pembayaran'] ?>"
                                                    class="action-btn btn btn-success"
                                                    onclick="return confirm('Verifikasi pembayaran ini?')">
                                                    <i class="fas fa-check"></i> Verifikasi
                                                </a>
                                            <?php else : ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile;
                            } else { ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-file-invoice-dollar me-2"></i> Belum ada data pembayaran
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="admin-footer">
                &copy; <?php echo date('Y'); ?> TirtoPesal. All rights reserved.
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Animasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Animasi untuk card container
            const cardContainer = document.querySelector('.card-container');
            setTimeout(() => {
                cardContainer.classList.add('fade-in');
            }, 300);

            // Animasi untuk setiap baris tabel
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';

                setTimeout(() => {
                    row.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateX(0)';
                }, 300 + (index * 50));
            });

            // Efek hover dinamis untuk menu sidebar
            const menuItems = document.querySelectorAll('.sidebar a');
            menuItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    if (!this.classList.contains('active')) {
                        this.style.backgroundColor = 'rgba(142, 234, 109, 0.08)';
                    }
                });

                item.addEventListener('mouseleave', function() {
                    if (!this.classList.contains('active')) {
                        this.style.backgroundColor = '';
                    }
                });
            });

            // Animasi teks selamat datang
            const welcomeHeading = document.querySelector('.welcome-section h3');
            welcomeHeading.style.opacity = '0';
            welcomeHeading.style.transform = 'translateY(-10px)';

            setTimeout(() => {
                welcomeHeading.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                welcomeHeading.style.opacity = '1';
                welcomeHeading.style.transform = 'translateY(0)';
            }, 200);

            // Tampilkan alert jika ada
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('show');

                    // Sembunyikan setelah 5 detik
                    setTimeout(() => {
                        alert.classList.remove('show');
                        setTimeout(() => {
                            alert.remove();
                        }, 500);
                    }, 5000);
                }, 300);
            });

            // Fungsi filter dan pencarian
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const metodeFilter = document.getElementById('metodeFilter');
            const tableRowsAll = document.querySelectorAll('tbody tr');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;
                const metodeValue = metodeFilter.value;

                tableRowsAll.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const namaPelanggan = cells[1].textContent.toLowerCase();
                    const idPemesanan = cells[2].textContent.toLowerCase();
                    const metode = cells[3].textContent.toLowerCase();
                    const status = cells[6].textContent.toLowerCase();

                    const matchesSearch = namaPelanggan.includes(searchTerm) || idPemesanan.includes(searchTerm);
                    const matchesStatus = statusValue === '' || status.includes(statusValue);
                    const matchesMetode = metodeValue === '' || metode.includes(metodeValue);

                    if (matchesSearch && matchesStatus && matchesMetode) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            searchInput.addEventListener('input', filterTable);
            statusFilter.addEventListener('change', filterTable);
            metodeFilter.addEventListener('change', filterTable);
        });

        // Animasi saat menggulir halaman
        window.addEventListener('scroll', function() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach(el => {
                const position = el.getBoundingClientRect();
                // Jika elemen berada di viewport
                if (position.top < window.innerHeight * 0.9 && !el.classList.contains('animated')) {
                    el.style.animationDelay = '0.2s';
                    el.classList.add('animated');
                }
            });
        });
    </script>
</body>

</html>