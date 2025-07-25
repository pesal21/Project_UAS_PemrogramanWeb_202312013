<?php
include '../includes/koneksi.php';

// Ambil data laporan gabung dengan pemesanan, pelanggan, dan tujuan
$query = mysqli_query($conn, "
    SELECT 
        l.*, 
        p.nama_pelanggan, 
        t.kota_tujuan,
        pm.metode_pembayaran,
        pm.total_bayar
    FROM laporan l
    JOIN pemesanan pm ON l.id_pemesanan = pm.id_pemesanan
    JOIN pelanggan p ON pm.id_pelanggan = p.id_pelanggan
    JOIN tujuan t ON pm.id_tujuan = t.id_tujuan
    ORDER BY l.tanggal_laporan DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - TirtoPesal</title>
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

        .text-muted {
            color: var(--text-secondary) !important;
        }

        .total-amount {
            background-color: rgba(142, 234, 109, 0.1);
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid var(--brand-color);
        }

        .total-label {
            font-size: 1.1rem;
            font-weight: 500;
        }

        .total-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--brand-color);
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

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.02);
            }

            100% {
                transform: scale(1);
            }
        }

        .fade-in {
            animation: fadeInUp 0.6s forwards;
        }

        .pulse {
            animation: pulse 2s infinite;
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

            .total-amount {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
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
            <a href="../pembayaran/index.php">
                <i class="fas fa-money-bill-wave"></i>
                <span>Pembayaran</span>
            </a>
            <a href="index.php" class="active">
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
                <h3 class="text-brand fw-semibold">Laporan Transaksi</h3>
                <p>Analisis semua transaksi perjalanan TirtoPesal</p>
            </div>

            <!-- Card Container -->
            <div class="card-container fade-in">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Pelanggan</th>
                                <th>Tujuan</th>
                                <th>Metode</th>
                                <th>Total Bayar</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($query) > 0) : ?>
                                <?php
                                $no = 1;
                                $totalPendapatan = 0;
                                while ($row = mysqli_fetch_assoc($query)) :
                                    $totalPendapatan += $row['total_bayar'];
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= date('d/m/Y', strtotime($row['tanggal_laporan'])) ?></td>
                                        <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                                        <td><?= htmlspecialchars($row['kota_tujuan']) ?></td>
                                        <td><?= htmlspecialchars($row['metode_pembayaran']) ?></td>
                                        <td>Rp<?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
                                        <td><?= htmlspecialchars($row['keterangan']) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-file-invoice-dollar me-2"></i> Belum ada data laporan
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (mysqli_num_rows($query) > 0) : ?>
                    <div class="total-amount pulse">
                        <div class="total-label">
                            <i class="fas fa-chart-line me-2"></i> Total Pendapatan:
                        </div>
                        <div class="total-value">
                            Rp<?= number_format($totalPendapatan, 0, ',', '.') ?>
                        </div>
                    </div>
                <?php endif; ?>
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