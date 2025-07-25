<?php
session_start();
include '../includes/koneksi.php';

if (!isset($_SESSION['pelanggan'])) {
    header("Location: login.php");
    exit;
}
$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];

// Tangkap notifikasi logout jika ada
$logout_notif = isset($_GET['logout']) ? true : false;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - TirtoPesal</title>
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

        p,
        .fitur-text,
        .card-text,
        .modal-body,
        .form-label {
            font-family: 'Roboto', sans-serif;
        }

        .navbar .nav-link,
        .navbar .btn,
        .btn {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }

        .navbar {
            background-color: rgba(28, 28, 28, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            padding: 10px 0;
        }

        .navbar .nav-link,
        .navbar .btn {
            color: var(--primary-color) !important;
            border: 1px solid rgba(142, 234, 109, 0.3);
            border-radius: 8px;
            padding: 6px 14px;
            margin-left: 8px;
            transition: all 0.3s ease;
            background-color: transparent;
        }

        .navbar .nav-link:hover {
            background-color: rgba(142, 234, 109, 0.15);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .navbar-brand {
            color: var(--primary-color) !important;
            font-weight: 700;
            font-size: 1.4rem;
        }

        .navbar-brand img {
            vertical-align: middle;
            margin-right: 10px;
            filter: drop-shadow(0 0 5px rgba(142, 234, 109, 0.5));
        }

        .card {
            background: linear-gradient(145deg, #3c3c3c, #2e2e2e);
            border: 1px solid #4a4a4a;
            color: #f0f0f0;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.6);
            border-color: rgba(142, 234, 109, 0.7);
        }

        .card-footer {
            background-color: #2a2a2a;
            border-top: 1px solid #3d3d3d;
        }

        .modal-content {
            background: linear-gradient(145deg, #3a3a3a, #2d2d2d);
            color: white;
            border-radius: 15px;
            border: 1px solid var(--primary-color);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
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

        .btn-outline-secondary {
            border-color: #666;
            color: #ccc;
            border-radius: 8px;
            padding: 10px;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background-color: #444;
            color: white;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .badge {
            font-size: 0.75rem;
            background-color: rgba(142, 234, 109, 0.15);
            color: var(--primary-color);
            margin-right: 5px;
            padding: 6px 12px;
            border-radius: 12px;
            font-weight: 500;
            border: 1px solid rgba(142, 234, 109, 0.3);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
            transition: transform 0.5s ease;
            border-bottom: 1px solid #4a4a4a;
        }

        .card:hover .card-img-top {
            transform: scale(1.08);
        }

        .review-section {
            max-height: 200px;
            overflow-y: auto;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            margin-top: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .review-section::-webkit-scrollbar {
            width: 8px;
        }

        .review-section::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        .review-section::-webkit-scrollbar-thumb {
            background-color: var(--primary-color);
            border-radius: 4px;
        }

        .review-item {
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .star-rating {
            color: #FFD700;
            font-size: 0.9rem;
            margin-right: 5px;
            text-shadow: 0 0 3px rgba(255, 215, 0, 0.5);
        }

        .no-review {
            color: #aaa;
            font-style: italic;
            text-align: center;
            padding: 10px;
        }

        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
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

        .price-tag {
            background: rgba(142, 234, 109, 0.2);
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
            margin: 12px 0;
            font-size: 1.1rem;
            border: 1px solid rgba(142, 234, 109, 0.3);
        }

        /* Loading spinner */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s;
        }

        .spinner {
            width: 70px;
            height: 70px;
            border: 5px solid rgba(142, 234, 109, 0.3);
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Toast notification */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
        }

        .toast {
            background: linear-gradient(145deg, #2d2d2d, #1f1f1f);
            border: 1px solid var(--primary-color);
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            transform: translateX(110%);
            transition: transform 0.3s ease-out;
        }

        .toast.show {
            transform: translateX(0);
        }

        .toast i {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-right: 10px;
        }

        /* Rating stars */
        .rating-input {
            display: flex;
            gap: 5px;
            margin-top: 8px;
        }

        .rating-input .star {
            font-size: 1.8rem;
            cursor: pointer;
            color: #555;
            transition: all 0.2s ease;
        }

        .rating-input .star:hover,
        .rating-input .star.active {
            color: #FFD700;
            transform: scale(1.2);
            text-shadow: 0 0 8px rgba(255, 215, 0, 0.7);
        }

        .rating-input .star:hover~.star {
            color: #555;
        }

        /* Account dropdown */
        .dropdown-menu {
            background: #2d2d2d;
            border: 1px solid #444;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
        }

        .dropdown-item {
            color: #ddd;
            padding: 8px 16px;
            border-radius: 6px;
            margin: 3px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: rgba(142, 234, 109, 0.1);
            color: var(--primary-color);
        }

        .dropdown-divider {
            border-color: #444;
        }

        /* Card badge container */
        .badge-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 12px 0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navbar .nav-link {
                margin: 5px 0;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .card {
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Loading overlay -->
    <div id="loading-overlay">
        <div class="spinner"></div>
    </div>

    <!-- Toast notification -->
    <div class="toast-container">
        <?php if ($logout_notif): ?>
            <div class="toast" id="logout-toast">
                <i class="bi bi-check-circle-fill"></i>
                <div>
                    <strong>Logout Berhasil!</strong>
                    <p>Anda telah keluar dari sistem</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

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
                        <a class="nav-link active" aria-current="page" href="../index.php">
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
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i> Akun
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="profil.php"><i class="bi bi-person me-2"></i>Profil</a></li>
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
        <h3 class="mb-4 section-title">Unit Mobil Tersedia</h3>
        <div class="row">
            <?php
            $query = "SELECT * FROM mobil ORDER BY id_mobil DESC";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                $id_mobil = $row['id_mobil'];
                $gambar_path = "../img/" . $row['gambar'];
                $gambar_tampil = file_exists($gambar_path) ? $gambar_path : "../img/default.png";
            ?>
                <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="<?= $id_mobil * 50 ?>">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= $gambar_tampil ?>" class="card-img-top" alt="<?= $row['nama_mobil'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['nama_mobil'] ?></h5>
                            <div class="price-tag">Rp<?= number_format($row['harga'], 0, ',', '.') ?></div>
                            <div class="badge-container">
                                <span class="badge">AC</span>
                                <span class="badge">USB</span>
                                <span class="badge">Reclining Seat</span>
                                <span class="badge">Musik</span>
                            </div>

                            <div class="review-section">
                                <?php
                                $ulasan = mysqli_query($conn, "SELECT u.*, p.nama_pelanggan 
                                    FROM ulasan u 
                                    JOIN pelanggan p ON u.id_pelanggan = p.id_pelanggan 
                                    WHERE u.id_mobil = $id_mobil
                                    ORDER BY u.id_ulasan DESC LIMIT 3");

                                if (mysqli_num_rows($ulasan) > 0) {
                                    echo "<h6>Ulasan Pelanggan:</h6>";
                                    while ($u = mysqli_fetch_assoc($ulasan)) {
                                        echo "<div class='review-item'>";
                                        echo "<p class='mb-0'><strong>{$u['nama_pelanggan']}</strong></p>";
                                        echo "<div class='star-rating d-inline-block'>";
                                        for ($i = 1; $i <= 5; $i++) {
                                            echo ($i <= $u['rating']) ? "★" : "☆";
                                        }
                                        echo "</div>";
                                        echo "<p class='mb-0 small'><em>{$u['isi_ulasan']}</em></p>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "<p class='no-review small'>Belum ada ulasan</p>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 d-grid gap-2 pb-3">
                            <a href="pesan.php?id_mobil=<?= $row['id_mobil'] ?>" class="btn btn-primary">
                                <i class="bi bi-cart-check me-1"></i> Pesan Sekarang
                            </a>
                            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalUlasan<?= $id_mobil ?>">
                                <i class="bi bi-star me-1"></i> Beri Ulasan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal Ulasan -->
                <div class="modal fade" id="modalUlasan<?= $id_mobil ?>" tabindex="-1" aria-labelledby="modalLabel<?= $id_mobil ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="ulasan.php" method="POST">
                            <div class="modal-content">
                                <div class="modal-header border-0">
                                    <h5 class="modal-title" id="modalLabel<?= $id_mobil ?>">
                                        <i class="bi bi-star-fill me-2 text-warning"></i> Beri Ulasan untuk <?= $row['nama_mobil'] ?>
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id_mobil" value="<?= $id_mobil ?>">
                                    <input type="hidden" name="id_pelanggan" value="<?= $id_pelanggan ?>">
                                    <div class="mb-4">
                                        <label class="form-label">Rating</label>
                                        <div class="rating-input">
                                            <span class="star" data-value="1">☆</span>
                                            <span class="star" data-value="2">☆</span>
                                            <span class="star" data-value="3">☆</span>
                                            <span class="star" data-value="4">☆</span>
                                            <span class="star" data-value="5">☆</span>
                                            <input type="hidden" name="rating" id="ratingInput<?= $id_mobil ?>" value="" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ulasan<?= $id_mobil ?>" class="form-label">Ulasan</label>
                                        <textarea name="isi_ulasan" class="form-control" id="ulasan<?= $id_mobil ?>" rows="4" required placeholder="Bagikan pengalaman Anda..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-send me-1"></i> Kirim Ulasan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            <?php } ?>
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

        // Fungsi untuk set rating
        function setRating(id, value) {
            const stars = document.querySelectorAll(`#modalUlasan${id} .star`);
            const ratingInput = document.getElementById(`ratingInput${id}`);

            stars.forEach((star, index) => {
                if (index < value) {
                    star.textContent = '★';
                    star.style.color = '#FFD700';
                    star.classList.add('active');
                } else {
                    star.textContent = '☆';
                    star.style.color = '#555';
                    star.classList.remove('active');
                }
            });

            ratingInput.value = value;
        }

        // Atur event listener untuk bintang rating
        document.querySelectorAll('.rating-input .star').forEach(star => {
            star.addEventListener('click', function() {
                const modalId = this.closest('.modal').id.replace('modalUlasan', '');
                const value = parseInt(this.getAttribute('data-value'));
                setRating(modalId, value);
            });

            star.addEventListener('mouseenter', function() {
                const value = parseInt(this.getAttribute('data-value'));
                const stars = this.parentElement.children;

                for (let i = 0; i < stars.length; i++) {
                    if (i < value) {
                        stars[i].textContent = '★';
                        stars[i].style.color = '#FFD700';
                    }
                }
            });

            star.addEventListener('mouseleave', function() {
                const stars = this.parentElement.children;
                const modalId = this.closest('.modal').id.replace('modalUlasan', '');
                const ratingInput = document.getElementById(`ratingInput${modalId}`);
                const currentRating = parseInt(ratingInput.value) || 0;

                for (let i = 0; i < stars.length; i++) {
                    if (i >= currentRating) {
                        stars[i].textContent = '☆';
                        stars[i].style.color = '#555';
                    }
                }
            });
        });

        // Efek paralaks untuk background
        window.addEventListener('scroll', function() {
            const scrollPosition = window.pageYOffset;
            document.body.style.backgroundPositionY = -(scrollPosition * 0.3) + 'px';
        });

        // Animasi tombol
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transition = 'transform 0.2s ease, box-shadow 0.2s ease';
                this.style.transform = 'translateY(-3px)';
            });

            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Loading overlay
        window.addEventListener('load', function() {
            setTimeout(function() {
                const loadingOverlay = document.getElementById('loading-overlay');
                loadingOverlay.style.opacity = '0';
                setTimeout(() => loadingOverlay.style.display = 'none', 500);

                // Tampilkan toast notifikasi
                const toast = document.getElementById('logout-toast');
                if (toast) {
                    setTimeout(() => {
                        toast.classList.add('show');
                        setTimeout(() => toast.classList.remove('show'), 3000);
                    }, 800);
                }
            }, 800);
        });

        // Efek hover pada card
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>

</html>