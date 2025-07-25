<?php
session_start();
include '../includes/koneksi.php';

if (!isset($_SESSION['pelanggan'])) {
    header("Location: login.php");
    exit;
}

$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];

// Ambil data pelanggan
$query = "SELECT * FROM pelanggan WHERE id_pelanggan = $id_pelanggan";
$result = mysqli_query($conn, $query);
$pelanggan = mysqli_fetch_assoc($result);

// Jika ada update profil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $update_query = "UPDATE pelanggan SET 
                     nama_pelanggan = '$nama',
                     email = '$email',
                     no_hp = '$no_hp',
                     alamat = '$alamat'
                     WHERE id_pelanggan = $id_pelanggan";

    if (mysqli_query($conn, $update_query)) {
        // Update session
        $_SESSION['pelanggan']['nama_pelanggan'] = $nama;
        $_SESSION['pelanggan']['email'] = $email;
        $_SESSION['pelanggan']['no_hp'] = $no_hp;
        $_SESSION['pelanggan']['alamat'] = $alamat;

        $success = "Profil berhasil diperbarui!";
    } else {
        $error = "Terjadi kesalahan: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Akun - TirtoPesal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Open+Sans:wght@400;600&family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #8eea6d;
            --secondary-color: #1c1c1c;
            --accent-color: #7cd95c;
        }

        body {
            background: linear-gradient(to right, rgba(0, 0, 0, 0.85), rgba(15, 15, 15, 0.9)), url('../img/latar.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            font-family: 'Open Sans', sans-serif;
            min-height: 100vh;
            padding-top: 70px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .navbar {
            background-color: rgba(28, 28, 28, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            padding: 10px 0;
        }

        .navbar .nav-link,
        .navbar .btn,
        .btn {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }

        .card {
            background: linear-gradient(145deg, #3c3c3c, #2e2e2e);
            border: 1px solid #4a4a4a;
            color: #f0f0f0;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
        }

        .btn-primary {
            background: linear-gradient(145deg, var(--primary-color), var(--accent-color));
            border: none;
            color: #1f1f1f;
            font-weight: 600;
            border-radius: 8px;
            padding: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(145deg, var(--accent-color), var(--primary-color));
            transform: scale(1.05) translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .profile-header {
            text-align: center;
            padding: 30px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: linear-gradient(to right, rgba(40, 40, 40, 0.8), rgba(30, 30, 30, 0.9));
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at top right, rgba(142, 234, 109, 0.1), transparent 70%);
        }

        .avatar-container {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }

        .avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid rgba(142, 234, 109, 0.3);
            background: linear-gradient(145deg, #2a2a2a, #1c1c1c);
            box-shadow: 0 0 25px rgba(142, 234, 109, 0.3);
        }

        .avatar-edit {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: var(--primary-color);
            color: #1c1c1c;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .avatar-edit:hover {
            transform: scale(1.1);
        }

        .profile-info {
            padding: 30px;
        }

        .info-item {
            display: flex;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-icon {
            min-width: 40px;
            font-size: 1.4rem;
            color: var(--primary-color);
            text-align: center;
            margin-right: 15px;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 0.9rem;
            color: #aaa;
            margin-bottom: 3px;
        }

        .info-value {
            font-size: 1.1rem;
        }

        .edit-icon {
            color: var(--primary-color);
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.2s ease;
        }

        .edit-icon:hover {
            transform: scale(1.2);
        }

        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 25px;
            font-size: 1.8rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), transparent);
            border-radius: 2px;
        }

        .form-control {
            background-color: #333;
            border: 1px solid #444;
            color: white;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: #333;
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(142, 234, 109, 0.25);
        }

        .form-label {
            color: #ddd;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .stats-container {
            display: flex;
            justify-content: space-around;
            text-align: center;
            margin: 30px 0;
        }

        .stat-item {
            padding: 15px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #aaa;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 42px;
            color: #aaa;
            cursor: pointer;
            z-index: 10;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .avatar {
                width: 120px;
                height: 120px;
            }

            .profile-info {
                padding: 20px 15px;
            }

            .stats-container {
                flex-direction: column;
                gap: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../img/logo.png" alt="Logo" width="35" height="35" class="d-inline-block align-text-top me-2">
                TirtoPesal Travel
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">
                            <i class="bi bi-house-door me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-grid me-1"></i> Layanan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-car-front me-2"></i>Sewa Mobil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-geo-alt me-2"></i>Paket Wisata</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i> Akun
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item active" href="profil.php"><i class="bi bi-person me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="riwayat.php"><i class="bi bi-receipt me-2"></i>Pesanan Saya</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="../logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5 pt-4">
        <div class="row">
            <div class="col-lg-4 mb-4" data-aos="fade-right">
                <div class="card">
                    <div class="profile-header">
                        <div class="avatar-container">
                            <img src="../img/avatar.png" alt="Avatar" class="avatar">
                            <div class="avatar-edit" data-bs-toggle="tooltip" title="Ubah Foto">
                                <i class="bi bi-camera"></i>
                            </div>
                        </div>
                        <h3><?= $pelanggan['nama_pelanggan'] ?></h3>
                        <p class="text-muted">Pelanggan TirtoPesal</p>
                        <span class="badge rounded-pill bg-success">Member Aktif</span>
                    </div>

                    <div class="stats-container">
                        <div class="stat-item">
                            <div class="stat-number">12</div>
                            <div class="stat-label">Pesanan</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">8.7</div>
                            <div class="stat-label">Rating</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">2</div>
                            <div class="stat-label">Tahun</div>
                        </div>
                    </div>

                    <div class="card-footer text-center p-3">
                        <small class="text-muted">Bergabung sejak <?= date('d M Y', strtotime($pelanggan['tanggal_daftar'])) ?></small>
                    </div>
                </div>
            </div>

            <div class="col-lg-8" data-aos="fade-left">
                <div class="card">
                    <div class="card-body">
                        <h3 class="section-title">Profil Saya</h3>

                        <?php if (isset($success)): ?>
                            <div class="alert alert-success"><?= $success ?></div>
                        <?php endif; ?>

                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="POST" action="profil.php">
                            <div class="mb-4">
                                <label class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" name="nama" value="<?= $pelanggan['nama_pelanggan'] ?>" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" name="email" value="<?= $pelanggan['email'] ?>" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="text" class="form-control" name="no_hp" value="<?= $pelanggan['no_hp'] ?>" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Alamat</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <textarea class="form-control" name="alamat" rows="3" required><?= $pelanggan['alamat'] ?></textarea>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-save me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>

                        <hr class="my-5">

                        <h3 class="section-title">Keamanan Akun</h3>

                        <div class="mb-4">
                            <label class="form-label">Password Saat Ini</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" value="password123" disabled>
                                <span class="password-toggle"><i class="bi bi-eye"></i></span>
                            </div>
                        </div>

                        <button class="btn btn-outline-secondary w-100" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="bi bi-key me-2"></i> Ubah Password
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="changePasswordModalLabel">
                        <i class="bi bi-key me-2"></i> Ubah Password
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label">Password Saat Ini</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" placeholder="Masukkan password saat ini">
                            <span class="password-toggle"><i class="bi bi-eye"></i></span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" class="form-control" placeholder="Masukkan password baru">
                            <span class="password-toggle"><i class="bi bi-eye"></i></span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                            <input type="password" class="form-control" placeholder="Konfirmasi password baru">
                            <span class="password-toggle"><i class="bi bi-eye"></i></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Simpan Password
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        // Inisialisasi AOS
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-out-back'
        });

        // Efek paralaks untuk background
        window.addEventListener('scroll', function() {
            const scrollPosition = window.pageYOffset;
            document.body.style.backgroundPositionY = -(scrollPosition * 0.3) + 'px';
        });

        // Password visibility toggle
        document.querySelectorAll('.password-toggle').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });

        // Tooltip initialization
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const inputs = this.querySelectorAll('input, textarea');
            let valid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    valid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!valid) {
                e.preventDefault();
                alert('Harap lengkapi semua kolom!');
            }
        });
    </script>
</body>

</html>