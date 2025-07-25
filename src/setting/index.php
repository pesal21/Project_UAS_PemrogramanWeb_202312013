<?php
include '../includes/koneksi.php';

// Ambil data setting
$data = mysqli_query($conn, "SELECT * FROM setting LIMIT 1");
$setting = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Aplikasi - TirtoPesal</title>
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

        .setting-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(20px);
            max-width: 800px;
            margin: 0 auto;
        }

        .setting-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: var(--brand-color);
        }

        .setting-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
        }

        .setting-table th {
            text-align: left;
            padding: 12px 20px;
            font-weight: 600;
            color: var(--brand-color);
            width: 30%;
        }

        .setting-table td {
            padding: 15px 20px;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            border-left: 2px solid var(--brand-color);
        }

        .setting-table tr {
            transition: transform 0.3s ease;
        }

        .setting-table tr:hover {
            transform: translateX(5px);
        }

        .btn-brand {
            background-color: var(--brand-color);
            color: #000;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-brand:hover {
            background-color: var(--brand-dark);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(142, 234, 109, 0.3);
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

            .setting-table th {
                width: 35%;
            }
        }

        @media (max-width: 768px) {
            .setting-table {
                display: block;
            }

            .setting-table tr {
                display: flex;
                flex-direction: column;
                margin-bottom: 20px;
            }

            .setting-table th,
            .setting-table td {
                width: 100%;
                display: block;
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
            <a href="../laporan/index.php">
                <i class="fas fa-chart-bar"></i>
                <span>Laporan</span>
            </a>
            <a href="index.php" class="active">
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
                <h3 class="text-brand fw-semibold">Pengaturan Aplikasi</h3>
                <p>Kelola konfigurasi sistem TirtoPesal</p>
            </div>

            <!-- Setting Card -->
            <div class="setting-card fade-in">
                <table class="setting-table">
                    <tr>
                        <th>Nama Aplikasi</th>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-signature me-3 text-brand"></i>
                                <span><?= htmlspecialchars($setting['nama_aplikasi']) ?></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Nomor WhatsApp</th>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fab fa-whatsapp me-3 text-brand"></i>
                                <span><?= htmlspecialchars($setting['nomor_wa']) ?></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>
                            <div class="d-flex">
                                <i class="fas fa-map-marker-alt me-3 mt-1 text-brand"></i>
                                <span><?= nl2br(htmlspecialchars($setting['alamat'])) ?></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>
                            <div class="d-flex">
                                <i class="fas fa-info-circle me-3 mt-1 text-brand"></i>
                                <span><?= nl2br(htmlspecialchars($setting['deskripsi'])) ?></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Instagram</th>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fab fa-instagram me-3 text-brand"></i>
                                <span><?= htmlspecialchars($setting['instagram']) ?></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Facebook</th>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fab fa-facebook me-3 text-brand"></i>
                                <span><?= htmlspecialchars($setting['facebook']) ?></span>
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="text-center mt-5">
                    <a href="edit.php" class="btn btn-brand">
                        <i class="fas fa-edit me-1"></i> Edit Pengaturan
                    </a>
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
            // Animasi untuk setting card
            const settingCard = document.querySelector('.setting-card');
            setTimeout(() => {
                settingCard.classList.add('fade-in');
            }, 300);

            // Animasi untuk setiap baris tabel
            const tableRows = document.querySelectorAll('.setting-table tr');
            tableRows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';

                setTimeout(() => {
                    row.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateX(0)';
                }, 300 + (index * 100));
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