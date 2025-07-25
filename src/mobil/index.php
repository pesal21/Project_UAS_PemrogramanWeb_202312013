<?php
include '../includes/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mobil - TirtoPesal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .header-section {
            margin-bottom: 30px;
            animation: fadeInDown 0.8s ease-out;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .view-toggle {
            display: flex;
            gap: 10px;
        }

        .view-btn {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            color: var(--text-secondary);
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .view-btn.active,
        .view-btn:hover {
            background: rgba(142, 234, 109, 0.15);
            color: var(--brand-color);
            border-color: var(--brand-color);
        }

        /* Table View */
        .table-container {
            overflow-x: auto;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.8s ease-out;
        }

        .table {
            background: var(--card-bg);
            color: var(--text-primary);
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead {
            background: var(--brand-color);
            color: #000;
        }

        .table thead th {
            padding: 15px 20px;
            font-weight: 600;
            border-bottom: 2px solid var(--brand-dark);
        }

        .table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .table tbody tr:last-child {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background: rgba(142, 234, 109, 0.05);
        }

        .table tbody td {
            padding: 15px 20px;
            vertical-align: middle;
        }

        .action-btns {
            display: flex;
            gap: 10px;
        }

        .btn-edit,
        .btn-delete {
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-edit {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .btn-edit:hover {
            background: rgba(255, 193, 7, 0.25);
            color: #ffc107;
        }

        .btn-delete {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .btn-delete:hover {
            background: rgba(220, 53, 69, 0.25);
            color: #dc3545;
        }

        /* Grid View */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
            display: none;
        }

        .car-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s;
        }

        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(142, 234, 109, 0.2);
        }

        .car-image {
            height: 180px;
            background: linear-gradient(45deg, #2b2b2b, #1a1a1a);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .car-image::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(142, 234, 109, 0.1), transparent);
            transform: rotate(30deg);
            animation: shine 2s infinite;
        }

        .car-image i {
            font-size: 4rem;
            color: var(--brand-color);
            opacity: 0.3;
        }

        .car-content {
            padding: 20px;
        }

        .car-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--brand-color);
        }

        .car-details {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin: 15px 0;
        }

        .car-detail {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
        }

        .car-detail i {
            width: 20px;
            color: var(--brand-color);
        }

        .car-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-add {
            background: var(--brand-color);
            color: #000;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .btn-add:hover {
            background: var(--brand-dark);
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

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes shine {
            to {
                transform: rotate(30deg) translate(100%, 100%);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s forwards;
        }

        .slide-in {
            animation: fadeInDown 0.5s forwards;
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

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 20px;
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 10px;
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                padding: 12px 15px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }

            .table tbody td:before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--brand-color);
                margin-right: 15px;
            }

            .table tbody td:last-child {
                border-bottom: none;
            }

            .action-btns {
                justify-content: center;
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .header-section {
                flex-direction: column;
                align-items: flex-start;
            }

            .view-toggle {
                align-self: flex-end;
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
            <a href="index.php" class="active">
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
            <a href="../setting/index.php">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
            <hr>
            <a href="/logout.php" class="logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header-section">
                <div>
                    <h3 class="text-brand fw-semibold mb-2">Data Mobil</h3>
                    <p class="text-muted">Kelola semua data kendaraan armada TirtoPesal</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="view-toggle">
                        <div class="view-btn active" id="tableViewBtn">
                            <i class="fas fa-table"></i>
                        </div>
                        <div class="view-btn" id="gridViewBtn">
                            <i class="fas fa-th-large"></i>
                        </div>
                    </div>
                    <a href="tambah.php" class="btn-add">
                        <i class="fas fa-plus"></i> Tambah Mobil
                    </a>
                </div>
            </div>

            <!-- Table View -->
            <div class="table-container" id="tableView">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Mobil</th>
                            <th>Kapasitas</th>
                            <th>Plat Nomor</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = mysqli_query($conn, "SELECT * FROM mobil");
                        $no = 1;
                        while ($d = mysqli_fetch_assoc($data)) {
                            echo "<tr class='slide-in'>
                                <td class='text-center' data-label='No'>{$no}</td>
                                <td data-label='Nama Mobil'>{$d['nama_mobil']}</td>
                                <td data-label='Kapasitas'>{$d['kapasitas']} Penumpang</td>
                                <td data-label='Plat Nomor'><span class='badge bg-dark'>{$d['plat_nomor']}</span></td>
                                <td data-label='Aksi' class='text-center'>
                                    <div class='action-btns'>
                                        <a href='edit.php?id={$d['id_mobil']}' class='btn-edit'>
                                            <i class='fas fa-edit'></i> Edit
                                        </a>
                                        <a href='hapus.php?id={$d['id_mobil']}' class='btn-delete' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>
                                            <i class='fas fa-trash'></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Grid View -->
            <div class="grid-container" id="gridView">
                <?php
                $data = mysqli_query($conn, "SELECT * FROM mobil");
                while ($d = mysqli_fetch_assoc($data)) {
                    echo "<div class='car-card'>
                        <div class='car-image'>
                            <i class='fas fa-car'></i>
                        </div>
                        <div class='car-content'>
                            <h4 class='car-title'>{$d['nama_mobil']}</h4>
                            <div class='car-details'>
                                <div class='car-detail'>
                                    <i class='fas fa-users'></i>
                                    <span>Kapasitas: {$d['kapasitas']} Penumpang</span>
                                </div>
                                <div class='car-detail'>
                                    <i class='fas fa-tag'></i>
                                    <span>Plat: {$d['plat_nomor']}</span>
                                </div>
                                <div class='car-detail'>
                                    <i class='fas fa-circle'></i>
                                    <span>Status: <span class='text-success'>Tersedia</span></span>
                                </div>
                            </div>
                            <div class='car-actions'>
                                <a href='edit.php?id={$d['id_mobil']}' class='btn-edit'>
                                    <i class='fas fa-edit'></i> Edit
                                </a>
                                <a href='hapus.php?id={$d['id_mobil']}' class='btn-delete' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>
                                    <i class='fas fa-trash'></i>
                                </a>
                            </div>
                        </div>
                    </div>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animasi untuk baris tabel
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                setTimeout(() => {
                    row.classList.add('slide-in');
                }, 100 * index);
            });

            // Animasi untuk kartu mobil
            setTimeout(() => {
                const carCards = document.querySelectorAll('.car-card');
                carCards.forEach((card, index) => {
                    setTimeout(() => {
                        card.classList.add('fade-in');
                    }, 150 * index);
                });
            }, 300);

            // Toggle view
            const tableViewBtn = document.getElementById('tableViewBtn');
            const gridViewBtn = document.getElementById('gridViewBtn');
            const tableView = document.getElementById('tableView');
            const gridView = document.getElementById('gridView');

            tableViewBtn.addEventListener('click', function() {
                tableView.style.display = 'block';
                gridView.style.display = 'none';
                tableViewBtn.classList.add('active');
                gridViewBtn.classList.remove('active');
            });

            gridViewBtn.addEventListener('click', function() {
                tableView.style.display = 'none';
                gridView.style.display = 'grid';
                tableViewBtn.classList.remove('active');
                gridViewBtn.classList.add('active');

                // Animate cards when switching to grid view
                const carCards = document.querySelectorAll('.car-card');
                carCards.forEach((card, index) => {
                    setTimeout(() => {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            card.classList.add('fade-in');
                        }, 50);
                    }, 50 * index);
                });
            });

            // Hover effect for table rows
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.01)';
                    this.style.boxShadow = '0 5px 15px rgba(142, 234, 109, 0.1)';
                });

                row.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                    this.style.boxShadow = '';
                });
            });
        });
    </script>
</body>

</html>