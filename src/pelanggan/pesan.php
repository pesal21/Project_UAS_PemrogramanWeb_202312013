<?php
session_start();
include '../includes/koneksi.php';

// Proses form pemesanan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_SESSION['user_id'];
    $id_mobil = $_POST['id_mobil'];
    $id_tujuan = $_POST['id_tujuan'];
    $jumlah_penumpang = $_POST['jumlah_penumpang'];
    $tanggal_berangkat = $_POST['tanggal_berangkat'];
    $metode_pembayaran = $_POST['metode_pembayaran'];

    // Handle file upload
    $bukti_pembayaran = null;
    if ($metode_pembayaran != 'cash' && isset($_FILES['bukti_pembayaran'])) {
        $target_dir = "../uploads/";

        // Buat folder jika belum ada
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = uniqid() . '_' . basename($_FILES["bukti_pembayaran"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file)) {
            $bukti_pembayaran = $target_file;
        }
    }

    // Simpan pemesanan
    $query = "INSERT INTO pemesanan (id_pelanggan, id_mobil, id_tujuan, jumlah_penumpang, tanggal_berangkat, metode_pembayaran, bukti_pembayaran, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, 'diproses')";

    $stmt = mysqli_prepare($conn, $query);

    // Handle parameter binding untuk NULL
    if ($bukti_pembayaran === null) {
        mysqli_stmt_bind_param(
            $stmt,
            "iiiisss",
            $id_user,
            $id_mobil,
            $id_tujuan,
            $jumlah_penumpang,
            $tanggal_berangkat,
            $metode_pembayaran,
            $bukti_pembayaran
        );
    } else {
        mysqli_stmt_bind_param(
            $stmt,
            "iiiisss",
            $id_user,
            $id_mobil,
            $id_tujuan,
            $jumlah_penumpang,
            $tanggal_berangkat,
            $metode_pembayaran,
            $bukti_pembayaran
        );
    }

    if (mysqli_stmt_execute($stmt)) {
        $id_pemesanan = mysqli_insert_id($conn);
        // PERBAIKAN PATH: Gunakan path relatif yang benar
        header("Location: ../pemesanan/ticket.php?id=" . $id_pemesanan);
        exit();
    } else {
        $error = "Gagal menyimpan pemesanan: " . mysqli_error($conn);
    }
}

// Query untuk data mobil
$query_mobil = "SELECT * FROM mobil";
$result_mobil = mysqli_query($conn, $query_mobil);
$mobil_data = ($result_mobil) ? mysqli_fetch_all($result_mobil, MYSQLI_ASSOC) : [];

// Query untuk data tujuan
$query_tujuan = "SELECT * FROM tujuan";
$result_tujuan = mysqli_query($conn, $query_tujuan);
$tujuan_data = ($result_tujuan) ? mysqli_fetch_all($result_tujuan, MYSQLI_ASSOC) : [];

$id_mobil_dipilih = isset($_GET['id_mobil']) ? $_GET['id_mobil'] : null;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan - TirtoPesal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Open+Sans:wght@400;600&family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #8eea6d;
            --primary-dark: #76d15a;
            --secondary: #1c1c1c;
            --accent: #ff7e5f;
        }

        body {
            background: linear-gradient(to right, rgba(0, 0, 0, 0.85), rgba(15, 15, 15, 0.85)), url('../img/latar.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            font-family: 'Open Sans', sans-serif;
            min-height: 100vh;
            padding-bottom: 50px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
        }

        p,
        .form-label,
        .alert {
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
        }

        .navbar {
            background-color: rgba(28, 28, 28, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            color: var(--primary) !important;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.03);
        }

        .navbar-brand img {
            transition: transform 0.5s ease;
        }

        .navbar .nav-link {
            color: #f0f0f0 !important;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            padding: 8px 20px;
            margin-left: 8px;
            border-radius: 50px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--primary), transparent);
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .navbar .nav-link:hover {
            background: rgba(142, 234, 109, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(142, 234, 109, 0.2);
        }

        .navbar .nav-link:hover::before {
            opacity: 0.3;
        }

        .navbar .nav-link.active {
            background: rgba(142, 234, 109, 0.25);
            color: var(--primary) !important;
        }

        .hero-section {
            padding: 60px 0 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 100%);
            z-index: -1;
        }

        .hero-title {
            font-size: 2.8rem;
            margin-bottom: 15px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            background: linear-gradient(to right, var(--primary), #b8f1a6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 700;
            letter-spacing: -0.5px;
            animation: fadeInDown 0.8s ease;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 30px;
            color: #d0d0d0;
            animation: fadeIn 1s ease 0.3s both;
        }

        .card {
            background: rgba(60, 60, 60, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(74, 74, 74, 0.5);
            border-radius: 16px;
            color: white;
            font-family: 'Roboto', sans-serif;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            overflow: hidden;
            animation: fadeInUp 0.8s ease;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }

        .card-header {
            background: rgba(40, 40, 40, 0.8);
            border-bottom: 1px solid rgba(142, 234, 109, 0.3);
            padding: 20px 25px;
            font-weight: 600;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-header i {
            color: var(--primary);
        }

        .form-control,
        .form-select {
            background-color: rgba(42, 42, 42, 0.8);
            color: white;
            border: 1px solid #555;
            font-family: 'Roboto', sans-serif;
            transition: all 0.3s ease;
            padding: 12px 15px;
            border-radius: 10px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(142, 234, 109, 0.25);
            background-color: rgba(50, 50, 50, 0.9);
        }

        .form-control:focus {
            transform: scale(1.01);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #e0e0e0;
        }

        .form-label i {
            color: var(--primary);
            width: 20px;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            color: #1f1f1f;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(142, 234, 109, 0.3);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 1.05rem;
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(142, 234, 109, 0.4);
        }

        .btn-primary:active {
            transform: translateY(1px);
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .btn-primary:hover::after {
            left: 100%;
        }

        .back-btn {
            background: rgba(60, 60, 60, 0.5);
            color: #e0e0e0;
            border: 1px solid #555;
            border-radius: 50px;
            padding: 8px 20px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-btn:hover {
            background: rgba(80, 80, 80, 0.7);
            color: var(--primary);
            border-color: var(--primary);
            transform: translateX(-5px);
        }

        .alert {
            border-radius: 12px;
            padding: 15px 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease;
        }

        .info-card {
            background: rgba(40, 40, 40, 0.7);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            border-left: 4px solid var(--primary);
        }

        .info-card h5 {
            color: var(--primary);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 30px;
            background: rgba(40, 40, 40, 0.5);
            border-radius: 12px;
            margin: 20px 0;
            border: 2px dashed #555;
            animation: pulse 2s infinite;
        }

        .empty-state i {
            font-size: 3rem;
            color: #8eea6d;
            margin-bottom: 15px;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(142, 234, 109, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(142, 234, 109, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(142, 234, 109, 0);
            }
        }

        .animated {
            animation-duration: 0.8s;
            animation-fill-mode: both;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .dropdown-animation {
            animation: dropdownSlide 0.5s ease;
        }

        @keyframes dropdownSlide {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }

            .card-header {
                font-size: 1.2rem;
                padding: 15px 20px;
            }

            .navbar .nav-link {
                padding: 8px 15px;
                margin-left: 5px;
                font-size: 0.9rem;
            }
        }
    </style>
    <script>
        function toggleUploadField() {
            const metode = document.getElementById('metode_pembayaran').value;
            const uploadField = document.getElementById('upload_bukti');

            if (metode === 'cash') {
                uploadField.style.display = 'none';
            } else {
                uploadField.style.display = 'block';
                uploadField.classList.add('dropdown-animation');
                setTimeout(() => {
                    uploadField.classList.remove('dropdown-animation');
                }, 500);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            document.querySelector('input[name="tanggal_berangkat"]').setAttribute('min', today);

            // Add animations to form elements
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.opacity = 0;
                group.style.transform = 'translateY(20px)';
                group.style.transition = 'all 0.5s ease';

                setTimeout(() => {
                    group.style.opacity = 1;
                    group.style.transform = 'translateY(0)';
                }, 300 + (index * 100));
            });

            // Add hover effect to navbar logo
            const logo = document.querySelector('.navbar-brand img');
            if (logo) {
                logo.addEventListener('mouseenter', function() {
                    this.style.transform = 'rotate(10deg)';
                });

                logo.addEventListener('mouseleave', function() {
                    this.style.transform = 'rotate(0deg)';
                });
            }

            // Add ripple effect to buttons
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const x = e.clientX - e.target.offsetLeft;
                    const y = e.clientY - e.target.offsetTop;

                    const ripples = document.createElement('span');
                    ripples.style.left = x + 'px';
                    ripples.style.top = y + 'px';
                    ripples.classList.add('ripple');

                    this.appendChild(ripples);

                    setTimeout(() => {
                        ripples.remove();
                    }, 600);
                });
            });

            // Animate dropdowns on focus
            const dropdowns = document.querySelectorAll('select');
            dropdowns.forEach(dropdown => {
                dropdown.addEventListener('focus', function() {
                    this.classList.add('dropdown-animation');
                    setTimeout(() => {
                        this.classList.remove('dropdown-animation');
                    }, 500);
                });
            });
        });
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="../img/LOGO.png" alt="Logo" width="40" height="40">
                TirtoPesal Travel
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-home"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="riwayat.php">
                            <i class="fas fa-history"></i> Riwayat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link back-btn" href="javascript:history.back()">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="container">
            <h1 class="hero-title">Pesan Perjalanan Anda</h1>
            <p class="hero-subtitle">Isi formulir di bawah ini untuk memesan perjalanan dengan kenyamanan dan keamanan terjamin</p>
        </div>
    </div>

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-ticket-alt"></i> Form Pemesanan Travel
                    </div>
                    <div class="card-body p-4">
                        <div class="info-card">
                            <h5><i class="fas fa-info-circle"></i> Informasi Penting</h5>
                            <p class="mb-0">Pastikan semua data yang Anda isi sudah benar. Pembayaran non-tunai memerlukan unggahan bukti pembayaran. Tiket akan dikirimkan setelah pemesanan berhasil.</p>
                        </div>

                        <?php
                        // Koneksi ke database
                        include '../includes/koneksi.php';

                        // Query untuk mengambil data mobil
                        $query_mobil = "SELECT * FROM mobil";
                        $result_mobil = mysqli_query($conn, $query_mobil);
                        $mobil_data = mysqli_fetch_all($result_mobil, MYSQLI_ASSOC);

                        // Query untuk mengambil data tujuan
                        $query_tujuan = "SELECT * FROM tujuan";
                        $result_tujuan = mysqli_query($conn, $query_tujuan);
                        $tujuan_data = mysqli_fetch_all($result_tujuan, MYSQLI_ASSOC);

                        // Ambil id_mobil yang dipilih jika ada
                        $id_mobil_dipilih = isset($_GET['id_mobil']) ? $_GET['id_mobil'] : null;
                        ?>

                        <?php if (false && !empty($pesan)): ?>
                            <div class="alert alert-warning mb-4"><?= $pesan ?></div>
                        <?php endif; ?>

                        <form method="POST" enctype="multipart/form-data" action="">>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-car"></i> Pilih Mobil</label>
                                <select name="id_mobil" class="form-select" required>
                                    <option value="">-- Pilih Mobil --</option>
                                    <?php
                                    // Menampilkan data mobil dari array simulasi
                                    foreach ($mobil_data as $mobil):
                                    ?>
                                        <option value="<?= $mobil['id_mobil'] ?>" <?= ($id_mobil_dipilih == $mobil['id_mobil']) ? 'selected' : '' ?>>
                                            <?= $mobil['nama_mobil'] ?> - Rp<?= number_format($mobil['harga']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-route"></i> Pilih Tujuan</label>
                                <select name="id_tujuan" class="form-select" required>
                                    <option value="">-- Pilih Tujuan --</option>
                                    <?php
                                    // Menampilkan data tujuan dari array simulasi
                                    foreach ($tujuan_data as $tujuan):
                                    ?>
                                        <option value="<?= $tujuan['id_tujuan'] ?>">
                                            <?= $tujuan['kota_asal'] ?> - <?= $tujuan['kota_tujuan'] ?> - Rp<?= number_format($tujuan['tarif']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label"><i class="fas fa-users"></i> Jumlah Penumpang</label>
                                        <input type="number" name="jumlah_penumpang" class="form-control" min="1" max="20" style="color:white" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label"><i class="fas fa-calendar-day"></i> Tanggal Berangkat</label>
                                        <input type="date" name="tanggal_berangkat" class="form-control" style="color:white" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-credit-card"></i> Metode Pembayaran</label>
                                <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" onchange="toggleUploadField()" required>
                                    <option value="">-- Pilih Metode --</option>
                                    <option value="cash">Cash (Bayar di Loket)</option>
                                    <option value="qris">QRIS</option>
                                    <option value="transfer">Transfer Bank</option>
                                </select>
                            </div>

                            <div class="form-group" id="upload_bukti" style="display:none;">
                                <label class="form-label"><i class="fas fa-file-upload"></i> Upload Bukti Pembayaran</label>
                                <input type="file" name="bukti_pembayaran" class="form-control">
                                <small class="text-muted">Format: JPG, PNG (Maks. 2MB)</small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3" href="../pemesanan/ticket.php">
                                <i class="fas fa-check-circle me-2"></i> Konfirmasi Pemesanan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add ripple effect style
        const style = document.createElement('style');
        style.innerHTML = `
            .btn .ripple {
                position: absolute;
                background: rgba(255, 255, 255, 0.3);
                transform: translate(-50%, -50%);
                border-radius: 50%;
                pointer-events: none;
                animation: rippleEffect 0.6s linear;
            }
            
            @keyframes rippleEffect {
                0% {
                    width: 0;
                    height: 0;
                    opacity: 0.5;
                }
                100% {
                    width: 500px;
                    height: 500px;
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>