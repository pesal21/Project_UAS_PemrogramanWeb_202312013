<?php
session_start();
include '../includes/koneksi.php';

// Ambil data pelanggan
$result = mysqli_query($conn, "SELECT * FROM pelanggan");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - TirtoPesal</title>
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

        .search-container {
            position: relative;
            margin-bottom: 20px;
            max-width: 300px;
        }

        .search-container i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        .search-container input {
            padding-left: 45px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            color: var(--text-primary);
            border-radius: 8px;
            height: 45px;
            width: 100%;
        }

        .search-container input:focus {
            border-color: var(--brand-color);
            box-shadow: 0 0 0 0.25rem rgba(142, 234, 109, 0.25);
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

        .customer-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s;
        }

        .customer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(142, 234, 109, 0.2);
        }

        .customer-header {
            background: rgba(142, 234, 109, 0.1);
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .customer-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--brand-color), #2b2b2b);
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #fff;
        }

        .customer-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--brand-color);
        }

        .customer-content {
            padding: 20px;
        }

        .customer-details {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin: 15px 0;
        }

        .customer-detail {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 0.95rem;
        }

        .customer-detail i {
            width: 20px;
            color: var(--brand-color);
            margin-top: 3px;
        }

        .customer-actions {
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

        .no-data {
            text-align: center;
            padding: 40px;
            color: var(--text-secondary);
            grid-column: 1 / -1;
        }

        .no-data i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: var(--text-secondary);
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
            <a href="../mobil/index.php">
                <i class="fas fa-car"></i>
                <span>Data Mobil</span>
            </a>
            <a href="index.php" class="active">
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
            <a href="../logout.php" class="logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header-section">
                <div>
                    <h3 class="text-brand fw-semibold mb-2">Data Pelanggan</h3>
                    <p class="text-muted">Kelola semua pelanggan TirtoPesal</p>
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
                        <i class="fas fa-plus"></i> Tambah Pelanggan
                    </a>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="search-container mb-4">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari pelanggan...">
            </div>

            <!-- Table View -->
            <div class="table-container" id="tableView">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Pelanggan</th>
                            <th>Nomor HP</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) : ?>
                                <tr class="slide-in customer-row">
                                    <td class="text-center" data-label="No"><?= $no++ ?></td>
                                    <td data-label="Nama"><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                                    <td data-label="Nomor HP"><?= htmlspecialchars($row['no_hp']) ?></td>
                                    <td data-label="Email"><?= htmlspecialchars($row['email']) ?></td>
                                    <td data-label="Alamat"><?= htmlspecialchars($row['alamat']) ?></td>
                                    <td data-label="Aksi" class="text-center">
                                        <div class="action-btns">
                                            <a href="edit.php?id=<?= $row['id_pelanggan'] ?>" class="btn-edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="hapus.php?id=<?= $row['id_pelanggan'] ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile;
                        } else { ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-user-slash fa-2x mb-3"></i>
                                    <p class="mb-0">Belum ada data pelanggan</p>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Grid View -->
            <div class="grid-container" id="gridView">
                <?php
                mysqli_data_seek($result, 0); // Reset pointer ke awal
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) : ?>
                        <div class="customer-card">
                            <div class="customer-header">
                                <div class="customer-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <h4 class="customer-name"><?= htmlspecialchars($row['nama_pelanggan']) ?></h4>
                            </div>
                            <div class="customer-content">
                                <div class="customer-details">
                                    <div class="customer-detail">
                                        <i class="fas fa-phone"></i>
                                        <span><?= htmlspecialchars($row['no_hp']) ?></span>
                                    </div>
                                    <div class="customer-detail">
                                        <i class="fas fa-envelope"></i>
                                        <span><?= htmlspecialchars($row['email']) ?></span>
                                    </div>
                                    <div class="customer-detail">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span><?= htmlspecialchars($row['alamat']) ?></span>
                                    </div>
                                </div>
                                <div class="customer-actions">
                                    <a href="edit.php?id=<?= $row['id_pelanggan'] ?>" class="btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="hapus.php?id=<?= $row['id_pelanggan'] ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                } else { ?>
                    <div class="no-data">
                        <i class="fas fa-user-slash"></i>
                        <h5>Belum ada data pelanggan</h5>
                        <p class="mb-0">Silakan tambahkan pelanggan baru</p>
                    </div>
                <?php } ?>
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

            // Animasi untuk kartu pelanggan
            setTimeout(() => {
                const customerCards = document.querySelectorAll('.customer-card');
                customerCards.forEach((card, index) => {
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
                const customerCards = document.querySelectorAll('.customer-card');
                customerCards.forEach((card, index) => {
                    setTimeout(() => {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            card.classList.add('fade-in');
                        }, 50);
                    }, 50 * index);
                });
            });

            // Fitur pencarian
            const searchInput = document.getElementById('searchInput');
            const customerRows = document.querySelectorAll('.customer-row');
            const customerCards = document.querySelectorAll('.customer-card');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();

                // Untuk tampilan tabel
                customerRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });

                // Untuk tampilan grid
                customerCards.forEach(card => {
                    const text = card.textContent.toLowerCase();
                    card.style.display = text.includes(searchTerm) ? '' : 'none';
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