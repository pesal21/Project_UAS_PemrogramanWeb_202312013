<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - TirtoPesal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Open+Sans:wght@400;600&family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(15, 15, 15, 0.7)), url('img/latar.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            font-family: 'Open Sans', sans-serif;
            overflow-x: hidden;
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
        .hero-subtext,
        .fitur-text,
        .kontak-admin p,
        footer p {
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
        }

        .navbar .nav-link,
        .navbar .btn,
        .btn {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }

        .navbar {
            background-color: #1c1c1c;
            z-index: 1030;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .navbar.navbar-scrolled {
            background-color: rgba(28, 28, 28, 0.95) !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar .nav-link.active,
        .navbar .btn.active {
            background-color: rgba(142, 234, 109, 0.15);
            border-color: #8eea6d !important;
            color: #8eea6d !important;
        }

        .navbar-nav .dropdown-menu {
            background-color: #2f2f2f;
            border: 1px solid #4a4a4a;
        }

        .dropdown-menu .dropdown-item {
            color: #ccc;
            font-weight: 400;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #3c3c3c;
            color: #8eea6d;
        }

        .navbar-brand {
            color: #8eea6d !important;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
        }

        .navbar-brand img {
            vertical-align: middle;
        }

        .navbar .nav-link {
            color: #8eea6d !important;
            border: 1px solid rgba(142, 234, 109, 0.4);
            border-radius: 12px;
            padding: 6px 14px;
            margin-left: 10px;
            transition: 0.3s ease;
            background-color: transparent;
        }

        .navbar .nav-link:hover {
            background-color: rgba(142, 234, 109, 0.1);
            color: #8eea6d !important;
            border-color: #8eea6d;
        }

        .navbar .btn {
            border-radius: 20px;
            transition: 0.3s ease;
        }

        .navbar .btn-outline-light {
            border-color: #8eea6d;
            color: #8eea6d;
        }

        .navbar .btn-outline-light:hover {
            background-color: #8eea6d;
            color: #1f1f1f;
        }

        .navbar .btn-primary {
            background-color: #8eea6d;
            border: none;
            color: #1f1f1f;
        }

        .navbar .btn-primary:hover {
            background-color: #7cd95c;
            color: #1f1f1f;
        }

        .btn-primary {
            background-color: #8eea6d;
            border-color: #8eea6d;
            color: #1f1f1f;
        }

        .btn-primary:hover {
            background-color: #7cd95c;
            border-color: #7cd95c;
        }

        .fitur-box {
            background-color: #3c3c3c;
            border: 1px solid #4a4a4a;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        .fitur-box:hover {
            transform: translateY(-10px);
            border-color: #8eea6d;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
        }

        .fitur-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 0;
            background: rgba(142, 234, 109, 0.1);
            transition: all 0.5s ease;
            z-index: -1;
        }

        .fitur-box:hover::before {
            height: 100%;
        }

        .fitur-title {
            color: #8eea6d;
        }

        footer {
            background-color: #1c1c1c;
            color: #aaa;
            padding: 20px 0;
        }

        .kontak-admin {
            background-color: #252525;
            color: #ccc;
            padding: 30px 0;
        }

        .kontak-admin h4 {
            color: #8eea6d;
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
        }

        .kontak-admin h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 70px;
            height: 3px;
            background: #8eea6d;
            border-radius: 3px;
        }

        .kontak-admin a {
            color: #9ff371;
            text-decoration: none;
            position: relative;
        }

        .kontak-admin a:hover {
            text-decoration: underline;
            color: #8eea6d;
        }

        .hero-text {
            color: #f0f0f0;
        }

        .hero-subtext {
            font-size: 1.1rem;
            max-width: 500px;
            line-height: 1.7;
        }

        @keyframes floating {
            0% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-15px) rotate(2deg);
            }

            100% {
                transform: translateY(0) rotate(0deg);
            }
        }

        .mobil-grid-wrapper {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-left: 50px;
            perspective: 1000px;
        }

        .mobil-row {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .mobil-row img {
            width: 280px;
            height: auto;
            object-fit: contain;
            transition: transform 0.5s ease;
            transform-style: preserve-3d;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .mobil-animasi {
            animation: floating 4s ease-in-out infinite;
            transform-origin: center bottom;
        }

        .delay-1 {
            animation-delay: 0s;
        }

        .delay-2 {
            animation-delay: 0.5s;
        }

        .delay-3 {
            animation-delay: 1s;
        }

        .delay-4 {
            animation-delay: 1.5s;
        }

        .hero-section {
            padding-top: 120px;
            padding-bottom: 80px;
        }

        .fitur-section {
            position: relative;
            overflow: hidden;
        }

        .fitur-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect fill="none" width="100" height="100"/><path fill="rgba(142,234,109,0.03)" d="M20,20 L80,20 L80,80 L20,80 Z" stroke="rgba(142,234,109,0.1)" stroke-width="1"/></svg>');
            background-size: 40px;
            opacity: 0.5;
            z-index: -1;
        }

        .particle {
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(142, 234, 109, 0.6);
            animation: floatParticle 15s infinite linear;
            z-index: -1;
        }

        @keyframes floatParticle {
            0% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100vh) translateX(100px);
                opacity: 0;
            }
        }

        .btn-primary {
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(30deg);
            transition: all 0.6s ease;
        }

        .btn-primary:hover {
            transform: scale(1.05);
        }

        .btn-primary:hover::after {
            transform: translateY(100%) rotate(30deg);
        }

        .glow-text {
            text-shadow: 0 0 10px rgba(142, 234, 109, 0.5);
        }

        /* Perbaikan responsif untuk mobile */
        @media (max-width: 768px) {
            .mobil-grid-wrapper {
                margin-left: 0;
                margin-top: 40px;
            }

            .hero-section {
                padding-top: 100px;
                padding-bottom: 40px;
            }

            .mobil-row {
                flex-direction: column;
                align-items: center;
            }

            .mobil-row img {
                width: 80%;
                max-width: 300px;
                margin-bottom: 20px;
            }

            .hero-text {
                font-size: 2.3rem;
            }

            .hero-subtext {
                font-size: 1rem;
                max-width: 100%;
                padding: 0 15px;
            }

            .navbar .nav-link {
                margin-left: 0;
                margin-top: 8px;
                width: 100%;
                text-align: center;
            }

            .navbar-nav {
                padding-top: 15px;
                padding-bottom: 15px;
            }

            .navbar .btn {
                width: 100%;
                margin-top: 8px;
            }

            .fitur-box {
                margin-bottom: 20px !important;
            }

            .navbar-toggler {
                background-color: #8eea6d;
                border: none;
            }

            .navbar-toggler-icon {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(0, 0, 0, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            }

            .dropdown-menu {
                width: 100%;
                text-align: center;
            }

            .kontak-admin {
                padding: 20px 15px;
            }

            .kontak-admin h4 {
                font-size: 1.5rem;
            }

            .kontak-admin p {
                font-size: 0.9rem;
            }

            .btn-lg {
                padding: 10px 20px;
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .hero-text {
                font-size: 1.8rem;
                padding: 0 15px;
            }

            .hero-subtext {
                font-size: 0.95rem;
            }

            .fitur-title {
                font-size: 1.4rem;
            }

            .navbar-brand {
                font-size: 1rem;
            }

            .navbar-brand img {
                width: 35px;
                height: 35px;
            }

            .btn-lg {
                width: 90%;
                margin: 0 auto;
                display: block;
            }
        }

        /* Animasi untuk mobile di-disable untuk performa */
        @media (max-width: 768px) {
            .mobil-animasi {
                animation: none;
            }

            .particle {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="img/LOGO.png" alt="Logo" width="45" height="45">
                TirtoPesal Travel
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link btn-outline-light <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">
                            <img src="../img/home-icon.svg" alt="Beranda" width="25" class="me-1"> Beranda
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="../img/services-icon.svg" alt="Layanan" width="25" class="me-1"> Layanan
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="pelanggan/pesan.php">Pesan Tiket</a></li>
                            <li><a class="dropdown-item" href="#jadwal">Cek Jadwal</a></li>
                            <li><a class="dropdown-item" href="#kontak">Kontak Admin</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-outline-light <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : ''; ?>" href="login.php">
                            <img src="../img/login-icon.svg" alt="Login" width="25" class="me-1"> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-outline-light <?php echo basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : ''; ?>" href="register.php">
                            <img src="../img/register-icon.svg" alt="Daftar" width="25" class="me-1"> Daftar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <div class="container hero-section">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 text-center text-md-start" data-aos="fade-right">
                <h1 class="display-4 hero-text glow-text">Selamat Datang di TirtoPesal</h1>
                <p class="lead hero-subtext">Pesan tiket travel Anda dengan mudah dan cepat melalui aplikasi kami. Nikmati perjalanan nyaman dengan armada terbaik kami.</p>
                <a href="login.php" class="btn btn-primary btn-lg mt-3 px-5 py-3">
                    <span class="fw-bold">Mulai Sekarang</span>
                </a>
            </div>
            <div class="col-lg-6 col-md-12 d-flex justify-content-center" data-aos="fade-left">
                <div class="mobil-grid-wrapper">
                    <div class="mobil-row mt-5">
                        <img src="img/hilux.png" alt="Mobil 1" class="img-fluid mobil-animasi delay-1" />
                        <img src="img/innova.png" alt="Mobil 2" class="img-fluid mobil-animasi delay-2" />
                    </div>
                    <div class="mobil-row">
                        <img src="img/fortuner.png" alt="Mobil 3" class="img-fluid mobil-animasi delay-3" />
                        <img src="img/hiace.png" alt="Mobil 4" class="img-fluid mobil-animasi delay-4" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fitur -->
    <div class="container my-5 py-5 fitur-section">
        <h2 class="text-center fitur-title mb-5" data-aos="zoom-in">Fitur Unggulan</h2>
        <div class="row text-center">
            <div class="col-md-4 mb-4" data-aos="fade-right">
                <div class="p-4 fitur-box rounded h-100">
                    <div class="icon-container mb-3">
                        <div class="feature-icon bg-dark d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 70px; height: 70px; background: rgba(142, 234, 109, 0.1) !important;">
                            <img src="../img/ticket-icon.svg" alt="Pesan Tiket" width="50">
                        </div>
                    </div>
                    <h4 class="fitur-title">Pesan Tiket</h4>
                    <p class="fitur-text">Pilih rute perjalanan, jadwal, dan mobil sesuai kebutuhan Anda.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up">
                <div class="p-4 fitur-box rounded h-100">
                    <div class="icon-container mb-3">
                        <div class="feature-icon bg-dark d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 70px; height: 70px; background: rgba(142, 234, 109, 0.1) !important;">
                            <img src="../img/schedule-icon.svg" alt="Manajemen Jadwal" width="40">
                        </div>
                    </div>
                    <h4 class="fitur-title">Manajemen Jadwal</h4>
                    <p class="fitur-text">Cek jadwal keberangkatan dan histori pemesanan Anda kapan saja.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-left">
                <div class="p-4 fitur-box rounded h-100">
                    <div class="icon-container mb-3">
                        <div class="feature-icon bg-dark d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 70px; height: 70px; background: rgba(142, 234, 109, 0.1) !important;">
                            <img src="../img/support-icon.svg" alt="Dukungan 24/7" width="40">
                        </div>
                    </div>
                    <h4 class="fitur-title">Dukungan 24/7</h4>
                    <p class="fitur-text">Layanan pelanggan siap membantu Anda kapan saja.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kontak -->
    <section class="kontak-admin" id="kontak">
        <div class="container" data-aos="fade-up">
            <h4>Kontak Admin</h4>
            <p>Jika Anda mengalami kendala, silakan hubungi kami:</p>
            <p>WhatsApp: <a href="https://wa.me/6281234567890" target="_blank">+62 812-3456-7890</a></p>
            <p>Email: <a href="mailto:admin@tirtopesal.com">admin@tirtopesal.com</a></p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-4">
        <p class="mb-0">© 2025 TirtoPesal. Semua hak dilindungi.</p>
    </footer>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        // Inisialisasi AOS
        AOS.init({
            duration: 800,
            once: true
        });

        // Efek scroll pada navbar
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Animasi partikel background
        function createParticles() {
            const container = document.querySelector('body');
            // Kurangi jumlah partikel untuk performa mobile
            const particleCount = window.innerWidth > 768 ? 30 : 10;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                // Random position
                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;

                // Random size
                const size = 3 + Math.random() * 7;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;

                // Random animation delay
                const delay = Math.random() * 15;
                particle.style.animationDelay = `${delay}s`;

                container.appendChild(particle);
            }
        }

        // Efek hover pada gambar mobil - hanya untuk desktop
        if (window.innerWidth > 768) {
            document.querySelectorAll('.mobil-row img').forEach(img => {
                img.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.1) rotate(1deg)';
                    this.style.zIndex = '10';
                    this.style.boxShadow = '0 15px 30px rgba(142, 234, 109, 0.3)';
                });

                img.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                    this.style.zIndex = '';
                    this.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.3)';
                });
            });
        }

        // Inisialisasi setelah halaman dimuat
        window.addEventListener('load', function() {
            createParticles();

            // Animasi teks hero secara bertahap
            const heroText = document.querySelector('.hero-text');
            const heroSubtext = document.querySelector('.hero-subtext');
            const heroBtn = document.querySelector('.btn-primary');

            setTimeout(() => {
                heroText.style.opacity = '1';
                heroText.style.transform = 'translateY(0)';
            }, 300);

            setTimeout(() => {
                heroSubtext.style.opacity = '1';
                heroSubtext.style.transform = 'translateY(0)';
            }, 600);

            setTimeout(() => {
                heroBtn.style.opacity = '1';
                heroBtn.style.transform = 'translateY(0)';
            }, 900);
        });

        // Perbaikan untuk menu dropdown pada mobile
        document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                if (window.innerWidth < 992) {
                    e.preventDefault();
                    const menu = this.nextElementSibling;
                    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
                }
            });
        });
    </script>
</body>

</html>