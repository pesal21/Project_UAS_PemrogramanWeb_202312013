<?php
include '../includes/koneksi.php';

$data = mysqli_query($conn, "SELECT * FROM setting LIMIT 1");
$setting = mysqli_fetch_assoc($data);

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_aplikasi'];
    $wa = $_POST['nomor_wa'];
    $alamat = $_POST['alamat'];
    $deskripsi = $_POST['deskripsi'];
    $ig = $_POST['instagram'];
    $fb = $_POST['facebook'];

    mysqli_query($conn, "UPDATE setting SET 
    nama_aplikasi = '$nama',
    nomor_wa = '$wa',
    alamat = '$alamat',
    deskripsi = '$deskripsi',
    instagram = '$ig',
    facebook = '$fb'
    WHERE id_setting = {$setting['id_setting']}
  ");

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengaturan - TirtoPesal</title>
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

        .form-card {
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

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: var(--brand-color);
        }

        .input-group {
            margin-bottom: 25px;
            position: relative;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
        }

        .input-group label i {
            margin-right: 10px;
            color: var(--brand-color);
            width: 20px;
            text-align: center;
        }

        .input-group input,
        .input-group textarea {
            width: 100%;
            padding: 12px 15px;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: var(--text-primary);
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }

        .input-group input:focus,
        .input-group textarea:focus {
            outline: none;
            border-color: var(--brand-color);
            box-shadow: 0 0 0 3px rgba(142, 234, 109, 0.2);
            transform: translateY(-2px);
        }

        .input-group input:hover,
        .input-group textarea:hover {
            border-color: rgba(255, 255, 255, 0.3);
        }

        .btn-brand {
            background-color: var(--brand-color);
            color: #000;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-right: 10px;
        }

        .btn-secondary {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-primary);
            border: none;
            padding: 12px 30px;
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

        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }

        .button-group {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            gap: 15px;
        }

        /* Form Layout Improvements */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .full-width {
            grid-column: span 2;
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

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        @keyframes glow {
            0% {
                box-shadow: 0 0 5px rgba(142, 234, 109, 0.5);
            }

            100% {
                box-shadow: 0 0 20px rgba(142, 234, 109, 0.8);
            }
        }

        .fade-in {
            animation: fadeInUp 0.6s forwards;
        }

        .float-animation {
            animation: float 4s ease-in-out infinite;
        }

        .glow-animation {
            animation: glow 1.5s alternate infinite;
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

            .form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .full-width {
                grid-column: span 1;
            }
        }

        @media (max-width: 768px) {
            .button-group {
                flex-direction: column;
                gap: 10px;
            }

            .btn-brand,
            .btn-secondary {
                width: 100%;
                justify-content: center;
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
                <h3 class="text-brand fw-semibold">Edit Pengaturan</h3>
                <p>Perbarui informasi aplikasi TirtoPesal</p>
            </div>

            <!-- Form Card -->
            <div class="form-card fade-in">
                <form method="post">
                    <div class="form-grid">
                        <!-- Kolom 1 -->
                        <div class="input-group">
                            <label for="nama_aplikasi">
                                <i class="fas fa-signature"></i> Nama Aplikasi
                            </label>
                            <input type="text" name="nama_aplikasi" id="nama_aplikasi"
                                value="<?= htmlspecialchars($setting['nama_aplikasi']) ?>"
                                class="form-control" required>
                        </div>

                        <div class="input-group">
                            <label for="nomor_wa">
                                <i class="fab fa-whatsapp"></i> Nomor WhatsApp
                            </label>
                            <input type="text" name="nomor_wa" id="nomor_wa"
                                value="<?= htmlspecialchars($setting['nomor_wa']) ?>"
                                class="form-control" required>
                        </div>

                        <!-- Kolom 2 -->
                        <div class="input-group">
                            <label for="instagram">
                                <i class="fab fa-instagram"></i> Instagram (opsional)
                            </label>
                            <input type="text" name="instagram" id="instagram"
                                value="<?= htmlspecialchars($setting['instagram']) ?>"
                                class="form-control">
                        </div>

                        <div class="input-group">
                            <label for="facebook">
                                <i class="fab fa-facebook"></i> Facebook (opsional)
                            </label>
                            <input type="text" name="facebook" id="facebook"
                                value="<?= htmlspecialchars($setting['facebook']) ?>"
                                class="form-control">
                        </div>

                        <!-- Full Width Fields -->
                        <div class="input-group full-width">
                            <label for="alamat">
                                <i class="fas fa-map-marker-alt"></i> Alamat
                            </label>
                            <textarea name="alamat" id="alamat" class="form-control"
                                rows="3" required><?= htmlspecialchars($setting['alamat']) ?></textarea>
                        </div>

                        <div class="input-group full-width">
                            <label for="deskripsi">
                                <i class="fas fa-info-circle"></i> Deskripsi (opsional)
                            </label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control"
                                rows="3"><?= htmlspecialchars($setting['deskripsi']) ?></textarea>
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="submit" name="simpan" class="btn btn-brand glow-animation">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>
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
            // Animasi untuk form card
            const formCard = document.querySelector('.form-card');
            setTimeout(() => {
                formCard.classList.add('fade-in');
            }, 300);

            // Animasi untuk setiap input group
            const inputGroups = document.querySelectorAll('.input-group');
            inputGroups.forEach((group, index) => {
                group.style.opacity = '0';
                group.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    group.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    group.style.opacity = '1';
                    group.style.transform = 'translateY(0)';
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
                welcomeHeading.classList.add('float-animation');
            }, 200);

            // Animasi untuk ikon form
            const formIcons = document.querySelectorAll('.input-group label i');
            formIcons.forEach((icon, i) => {
                setTimeout(() => {
                    icon.classList.add('float-animation');
                }, 500 + (i * 100));
            });

            // Animasi untuk tombol simpan
            const saveBtn = document.querySelector('.btn-brand');
            setTimeout(() => {
                saveBtn.classList.add('glow-animation');
            }, 1000);
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

        // Validasi form sebelum submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const namaApp = document.getElementById('nama_aplikasi').value.trim();
            const nomorWa = document.getElementById('nomor_wa').value.trim();
            const alamat = document.getElementById('alamat').value.trim();

            if (!namaApp || !nomorWa || !alamat) {
                e.preventDefault();
                alert('Mohon isi semua bidang yang wajib diisi!');

                // Tambahkan animasi getar pada bidang yang kosong
                if (!namaApp) {
                    shakeElement(document.getElementById('nama_aplikasi'));
                }
                if (!nomorWa) {
                    shakeElement(document.getElementById('nomor_wa'));
                }
                if (!alamat) {
                    shakeElement(document.getElementById('alamat'));
                }
            }
        });

        // Fungsi untuk animasi getar
        function shakeElement(element) {
            element.style.borderColor = '#dc3545';
            element.animate([{
                    transform: 'translateX(0)'
                },
                {
                    transform: 'translateX(-10px)'
                },
                {
                    transform: 'translateX(10px)'
                },
                {
                    transform: 'translateX(-10px)'
                },
                {
                    transform: 'translateX(10px)'
                },
                {
                    transform: 'translateX(0)'
                }
            ], {
                duration: 500
            });

            // Kembalikan border color setelah 2 detik
            setTimeout(() => {
                element.style.borderColor = 'rgba(255, 255, 255, 0.1)';
            }, 2000);
        }

        // Animasi saat input mendapatkan fokus
        const formInputs = document.querySelectorAll('input, textarea');
        formInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
                this.parentElement.style.zIndex = '1';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
                this.parentElement.style.zIndex = '0';
            });
        });
    </script>
</body>

</html>