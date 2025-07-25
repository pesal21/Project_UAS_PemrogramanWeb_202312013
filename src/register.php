<?php
include 'includes/koneksi.php';
include "includes/fungsi_log.php";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan - TirtoPesal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #8eea6d;
            --primary-hover: #adff8a;
            --secondary: #1a1a1a;
            --dark: #111;
            --light: #eee;
            --accent: #76cc58;
        }

        body {
            background-color: var(--dark);
            color: var(--light);
            background-image: radial-gradient(circle at 10% 20%, rgba(17, 17, 17, 0.9) 0%, rgba(26, 26, 26, 0.95) 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: var(--secondary);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            padding: 0.8rem 1.5rem;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.6rem;
            color: var(--primary) !important;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand:hover {
            color: var(--primary-hover) !important;
            transform: translateY(-2px);
        }

        .nav-link {
            color: var(--primary) !important;
            font-weight: 500;
            position: relative;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-hover) !important;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 80%;
        }

        .form-box {
            max-width: 500px;
            margin: 50px auto;
            background-color: rgba(34, 34, 34, 0.9);
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(142, 234, 109, 0.2), 0 0 0 1px rgba(142, 234, 109, 0.15);
            position: relative;
            overflow: hidden;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            animation: fadeIn 0.8s ease-out;
        }

        .form-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(142, 234, 109, 0.3), 0 0 0 1px rgba(142, 234, 109, 0.2);
        }

        .form-box::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(142, 234, 109, 0.1) 0%, transparent 70%);
            animation: rotate 15s linear infinite;
            z-index: -1;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h3 {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }

        h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            border-radius: 3px;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #ccc;
        }

        input.form-control {
            background-color: rgba(17, 17, 17, 0.7);
            color: var(--light);
            border: 1px solid rgba(142, 234, 109, 0.4);
            padding: 12px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        input.form-control:focus {
            background-color: rgba(17, 17, 17, 0.9);
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(142, 234, 109, 0.25);
            color: var(--light);
        }

        .input-group {
            margin-bottom: 16px;
        }

        .input-group-text {
            background-color: rgba(17, 17, 17, 0.7);
            border: 1px solid rgba(142, 234, 109, 0.4);
            color: #8eea6d;
            padding: 0 15px;
            border-right: none;
            border-radius: 8px 0 0 8px;
        }

        .btn-hijau {
            background-color: var(--primary);
            color: #000;
            border: none;
            padding: 12px 20px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-hijau:hover {
            background-color: var(--accent);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(142, 234, 109, 0.4);
        }

        .btn-hijau::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.6s ease;
            transform: translateX(-100%);
            z-index: -1;
        }

        .btn-hijau:hover::before {
            transform: translateX(100%);
        }

        .form-text {
            color: #aaa;
            text-align: center;
            margin-top: 20px;
        }

        .form-text a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: all 0.3s ease;
        }

        .form-text a:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        .form-text a::after {
            content: '→';
            margin-left: 5px;
            transition: transform 0.3s ease;
        }

        .form-text a:hover::after {
            transform: translateX(3px);
        }

        .alert {
            border-radius: 8px;
            margin-top: 20px;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .footer {
            text-align: center;
            padding: 20px 0;
            color: #777;
            font-size: 0.9rem;
            margin-top: auto;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #8eea6d;
            cursor: pointer;
        }

        .password-wrapper {
            position: relative;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            font-size: 1.8rem;
            color: var(--primary);
        }

        .form-icon {
            color: var(--primary);
            font-size: 1.2rem;
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg px-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <div class="logo-container">
                    <i href=""></i>
                    <span>TirtoPesal Travel</span>
                </div>
            </a>
            <div class="ms-auto d-flex align-items-center">
                <a href="index.php" class="nav-link">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <a href="login.php" class="nav-link">
                    <i class="fas fa-sign-in-alt me-1"></i> Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Form Daftar -->
    <div class="form-box">
        <h3><i class="fas fa-user-plus me-2"></i>Form Pendaftaran Pelanggan</h3>
        <form method="POST" action="" id="registrationForm">
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-user form-icon"></i>Nama Lengkap</label>
                <input type="text" class="form-control" name="nama" required placeholder="Masukkan nama lengkap Anda">
            </div>

            <div class="mb-3">
                <label class="form-label"><i class="fas fa-envelope form-icon"></i>Email</label>
                <input type="email" class="form-control" name="email" required placeholder="contoh@email.com">
            </div>

            <div class="mb-3">
                <label class="form-label"><i class="fas fa-user-circle form-icon"></i>Username</label>
                <input type="text" class="form-control" name="username" required placeholder="Buat username unik">
            </div>

            <div class="mb-3">
                <label class="form-label"><i class="fas fa-lock form-icon"></i>Password</label>
                <div class="password-wrapper">
                    <input type="password" class="form-control" name="password" id="password" required placeholder="Minimal 8 karakter">
                    <button type="button" class="password-toggle" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-hijau w-100 mt-2" name="daftar">
                <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
            </button>
            <div class="form-text mt-4">
                Sudah punya akun? <a href="login.php">Login di sini</a>
            </div>
        </form>

        <!-- Proses Daftar -->
        <?php
        if (isset($_POST['daftar'])) {
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $cek = mysqli_query($conn, "SELECT * FROM pelanggan WHERE username='$username'");
            if (mysqli_num_rows($cek) == 0) {
                mysqli_query($conn, "INSERT INTO pelanggan (nama_pelanggan, email, username, password) VALUES ('$nama', '$email', '$username', '$password')");
                echo "<div class='alert alert-success mt-3'>Pendaftaran berhasil! <a href='login.php' class='alert-link'>Login di sini</a></div>";
            } else {
                echo "<div class='alert alert-danger mt-3'>Username sudah digunakan! Silakan coba username lain.</div>";
            }
        }
        ?>
    </div>

    <div class="footer">
        &copy; <?php echo date('Y'); ?> TirtoPesal. Hak Cipta Dilindungi.
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animasi untuk password toggle
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });

            // Animasi saat form di-submit
            const form = document.getElementById('registrationForm');
            form.addEventListener('submit', function() {
                const button = this.querySelector('button[type="submit"]');
                button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                button.disabled = true;
            });

            // Animasi hover untuk input
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>

</html>