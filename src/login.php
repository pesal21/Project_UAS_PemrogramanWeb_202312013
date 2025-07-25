<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TirtoPesal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #8eea6d;
            --primary-dark: #7cd95c;
            --dark: #111;
            --dark-light: #1a1a1a;
            --darker: #0a0a0a;
        }

        body {
            background: linear-gradient(135deg, var(--darker), var(--dark));
            color: #eee;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            position: relative;
        }

        /* Background animation */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            background:
                radial-gradient(circle at 10% 20%, rgba(142, 234, 109, 0.05) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(142, 234, 109, 0.05) 0%, transparent 20%);
            z-index: -1;
        }

        .navbar {
            background-color: rgba(26, 26, 26, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(142, 234, 109, 0.2);
        }

        .navbar-brand,
        .nav-link {
            color: var(--primary) !important;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover,
        .nav-link:hover {
            color: #adff8a !important;
            text-shadow: 0 0 8px rgba(142, 234, 109, 0.5);
        }

        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: fadeIn 1s ease;
        }

        .login-box {
            max-width: 420px;
            width: 100%;
            background: rgba(34, 34, 34, 0.8);
            padding: 40px 35px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(142, 234, 109, 0.3),
                0 0 25px rgba(142, 234, 109, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(142, 234, 109, 0.2);
            transform: translateY(0);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .login-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6),
                0 0 0 1px var(--primary),
                0 0 35px rgba(142, 234, 109, 0.3);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: rgba(142, 234, 109, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--primary);
            animation: pulse 2s infinite;
        }

        .logo img {
            width: 50px;
            height: 50px;
        }

        .login-header h2 {
            color: var(--primary);
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 5px;
            text-shadow: 0 0 10px rgba(142, 234, 109, 0.3);
        }

        .login-header p {
            color: #aaa;
            font-size: 0.95rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            z-index: 2;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 14px 14px 14px 45px;
            background: rgba(30, 30, 30, 0.7);
            border: 1px solid #333;
            color: #eee;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(142, 234, 109, 0.2);
            background: rgba(40, 40, 40, 0.7);
            outline: none;
        }

        input[type="text"]::placeholder,
        input[type="password"]::placeholder {
            color: #777;
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            color: #111;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-size: 1rem;
            box-shadow: 0 5px 15px rgba(142, 234, 109, 0.3);
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(142, 234, 109, 0.4);
        }

        button:active {
            transform: translateY(1px);
        }

        .forgot-link {
            display: block;
            text-align: right;
            margin-top: 15px;
            color: #aaa;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: var(--primary);
            text-decoration: none;
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            color: #aaa;
            font-size: 0.95rem;
        }

        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .register-link a:hover {
            text-decoration: underline;
            text-shadow: 0 0 8px rgba(142, 234, 109, 0.4);
        }

        /* Animations */
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

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(142, 234, 109, 0.4);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(142, 234, 109, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(142, 234, 109, 0);
            }
        }

        .particle {
            position: absolute;
            background: rgba(142, 234, 109, 0.3);
            border-radius: 50%;
            pointer-events: none;
            z-index: -1;
        }

        footer {
            background: rgba(26, 26, 26, 0.8);
            color: #aaa;
            text-align: center;
            padding: 15px 0;
            font-size: 0.9rem;
            backdrop-filter: blur(5px);
            border-top: 1px solid rgba(142, 234, 109, 0.1);
        }

        /* ======================== */
        /* PERBAIKAN RESPONSIF MOBILE */
        /* ======================== */

        /* Navbar untuk mobile */
        @media (max-width: 768px) {
            .navbar {
                padding: 10px 15px;
            }

            .navbar .container-fluid {
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar .ms-auto {
                margin-top: 10px;
                width: 100%;
                display: flex;
                justify-content: space-between;
            }

            .nav-link {
                padding: 8px 12px !important;
                font-size: 0.9rem;
            }

            .navbar-brand {
                font-size: 1.1rem;
            }
        }

        /* Login container untuk mobile */
        @media (max-width: 576px) {
            .login-box {
                padding: 30px 20px;
                margin: 0 15px;
            }

            .logo {
                width: 60px;
                height: 60px;
            }

            .logo img {
                width: 40px;
                height: 40px;
            }

            .login-header h2 {
                font-size: 1.5rem;
            }

            .login-header p {
                font-size: 0.85rem;
            }

            input[type="text"],
            input[type="password"] {
                padding: 12px 12px 12px 40px;
                font-size: 0.9rem;
            }

            button {
                padding: 12px;
                font-size: 0.95rem;
            }

            .register-link {
                font-size: 0.9rem;
            }
        }

        /* Untuk layar sangat kecil */
        @media (max-width: 400px) {
            .navbar .ms-auto {
                flex-direction: column;
                align-items: center;
            }

            .nav-link {
                width: 100%;
                text-align: center;
                margin: 5px 0;
            }

            .login-box {
                padding: 25px 15px;
            }

            .login-header h2 {
                font-size: 1.4rem;
            }
        }

        /* Nonaktifkan animasi untuk perangkat mobile */
        @media (max-width: 768px) {
            .login-box:hover {
                transform: none;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5),
                    0 0 0 1px rgba(142, 234, 109, 0.3),
                    0 0 25px rgba(142, 234, 109, 0.15);
            }

            .logo {
                animation: none;
            }
        }
    </style>
</head>

<body>
    <?php
    include 'includes/koneksi.php';
    // Jika sudah login, arahkan ke dashboard masing-masing
    if (isset($_SESSION['admin'])) {
        header("Location: admin/dashboard.php");
        exit;
    }
    if (isset($_SESSION['pelanggan'])) {
        header("Location: pelanggan/dashboard.php");
        exit;
    }
    ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg px-3 py-3">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="img/LOGO.png" alt="Logo" width="40" height="40" class="me-2">
                <span class="fw-bold">TirtoPesal Travel</span>
            </a>
            <div class="ms-auto">
                <a href="index.php" class="nav-link d-inline px-3"><i class="fas fa-home me-1"></i> Beranda</a>
                <a href="register.php" class="nav-link d-inline px-3"><i class="fas fa-user-plus me-1"></i> Daftar</a>
            </div>
        </div>
    </nav>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <div class="logo-container">
                    <div class="logo">
                        <img src="img/LOGO.png" alt="TirtoPesal Logo">
                    </div>
                </div>
                <h2>Login TirtoPesal</h2>
                <p>Silakan masuk untuk melanjutkan ke dashboard</p>
            </div>

            <form action="proses_login.php" method="post">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Email atau Username" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <button type="submit">
                    <i class="fas fa-sign-in-alt me-2"></i> Masuk Sekarang
                </button>
            </form>

            <div class="register-link">
                Belum punya akun? <a href="register.php">Daftar disini</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-auto">
        <div class="container">
            <p class="mb-0">© 2025 TirtoPesal Travel. Semua hak dilindungi.</p>
        </div>
    </footer>

    <!-- JavaScript untuk Animasi -->
    <script>
        // Animasi partikel background
        document.addEventListener('DOMContentLoaded', function() {
            // Nonaktifkan animasi untuk perangkat mobile
            if (window.innerWidth > 768) {
                const colors = ['rgba(142, 234, 109, 0.3)', 'rgba(142, 234, 109, 0.2)', 'rgba(142, 234, 109, 0.15)'];

                function createParticle() {
                    const particle = document.createElement('div');
                    particle.classList.add('particle');

                    // Set random properties
                    const size = Math.random() * 10 + 2;
                    const posX = Math.random() * window.innerWidth;
                    const posY = Math.random() * window.innerHeight;
                    const color = colors[Math.floor(Math.random() * colors.length)];

                    particle.style.width = `${size}px`;
                    particle.style.height = `${size}px`;
                    particle.style.left = `${posX}px`;
                    particle.style.top = `${posY}px`;
                    particle.style.background = color;

                    // Animation
                    const animation = particle.animate([{
                            transform: 'translateY(0px)',
                            opacity: 1
                        },
                        {
                            transform: `translateY(${Math.random() * 100 - 50}px) translateX(${Math.random() * 100 - 50}px)`,
                            opacity: 0
                        }
                    ], {
                        duration: Math.random() * 5000 + 3000,
                        easing: 'cubic-bezier(0.2, 0, 0.8, 1)'
                    });

                    animation.onfinish = () => {
                        particle.remove();
                        createParticle();
                    };

                    document.body.appendChild(particle);
                }

                // Create initial particles
                for (let i = 0; i < 15; i++) {
                    createParticle();
                }
            }

            // Form animation on load
            const form = document.querySelector('form');
            form.style.opacity = '0';
            form.style.transform = 'translateY(20px)';

            setTimeout(() => {
                form.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                form.style.opacity = '1';
                form.style.transform = 'translateY(0)';
            }, 300);
        });
    </script>
</body>

</html>