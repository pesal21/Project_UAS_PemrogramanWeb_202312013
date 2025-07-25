<?php
session_start();
include '../includes/koneksi.php';

if (!isset($_GET['id'])) {
    die("ID pemesanan tidak valid");
}

$id_pemesanan = $_GET['id'];

$query = "SELECT 
            pemesanan.*, 
            mobil.nama_mobil, 
            mobil.plat_nomor, 
            mobil.harga AS tarif_mobil,
            tujuan.kota_asal, 
            tujuan.kota_tujuan, 
            tujuan.tarif AS tarif_tujuan
          FROM pemesanan
          JOIN mobil ON pemesanan.id_mobil = mobil.id_mobil
          JOIN tujuan ON pemesanan.id_tujuan = tujuan.id_tujuan
          WHERE pemesanan.id_pemesanan = ?";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_pemesanan);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pemesanan = mysqli_fetch_assoc($result);

if (!$pemesanan) {
    die("Data tiket tidak ditemukan");
}

$total_harga = ($pemesanan['tarif_mobil'] + $pemesanan['tarif_tujuan']) * $pemesanan['jumlah_penumpang'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Travel - TirtoPesal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS untuk halaman tiket */
        body {
            background: linear-gradient(135deg, #e6f4f1 0%, #d1e8e2 100%);
            font-family: 'Segoe UI', 'Roboto', 'Montserrat', sans-serif;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
        }

        .ticket-container {
            max-width: 950px;
            margin: 40px auto;
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(29, 106, 79, 0.25);
            position: relative;
            border: 1px solid #c8e6d9;
            transform: translateY(20px);
            opacity: 0;
            transition: transform 0.7s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.7s ease;
        }

        .ticket-container.show {
            transform: translateY(0);
            opacity: 1;
        }

        .ticket-header {
            background: linear-gradient(135deg, #1d6a4f 0%, #0a3c27 100%);
            padding: 30px 40px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            z-index: 2;
        }

        .ticket-header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.2;
        }

        .logo-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            position: relative;
            z-index: 2;
        }

        .logo-circle {
            width: 90px;
            height: 90px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .logo-circle:hover {
            transform: scale(1.05) rotate(5deg);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        .logo-circle i {
            font-size: 48px;
            color: #1d6a4f;
            background: linear-gradient(135deg, #1d6a4f 0%, #0a3c27 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .ticket-header h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            margin: 0;
            font-size: 2.8rem;
            letter-spacing: 1.5px;
            text-shadow: 0 3px 6px rgba(0, 0, 0, 0.25);
            background: linear-gradient(to bottom, #ffffff, #e0f7ed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            display: inline-block;
        }

        .ticket-header h1::after {
            content: "";
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(to right, #8fd3c9, #4db39e);
            border-radius: 3px;
        }

        .ticket-header p {
            margin: 15px 0 0;
            font-size: 1.3rem;
            opacity: 0.85;
            letter-spacing: 0.8px;
            font-weight: 300;
        }

        .ticket-body {
            padding: 35px 40px 40px;
            position: relative;
            background: #fff;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 140px;
            font-weight: 900;
            color: rgba(29, 106, 79, 0.035);
            pointer-events: none;
            z-index: 0;
            text-transform: uppercase;
            white-space: nowrap;
            font-family: 'Montserrat', sans-serif;
        }

        .ticket-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            position: relative;
            z-index: 2;
        }

        .ticket-section {
            background: #f8fdfb;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0f2ec;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .ticket-section:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(29, 106, 79, 0.15);
            border-color: #b8e1d3;
        }

        .ticket-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
            background: linear-gradient(to bottom, #1d6a4f, #4db39e);
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1d6a4f;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #d4e8de;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }

        .section-title i {
            background: #e0f7ed;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 8px rgba(29, 106, 79, 0.1);
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 14px 0;
            border-bottom: 1px dashed #e0f2ec;
            position: relative;
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background: #f0fbf7;
            border-radius: 8px;
            padding: 14px 12px;
            transform: translateX(5px);
            border-bottom: 1px dashed transparent;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #2d6a4f;
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
            transition: transform 0.3s ease;
        }

        .info-item:hover .info-label {
            transform: translateX(5px);
        }

        .info-value {
            font-weight: 600;
            text-align: right;
            flex: 1;
            color: #0a3c27;
            transition: transform 0.3s ease;
        }

        .info-item:hover .info-value {
            transform: translateX(-5px);
        }

        .total-price {
            background: linear-gradient(135deg, #d8f3dc 0%, #b7e4c7 100%);
            padding: 30px;
            border-radius: 16px;
            text-align: center;
            margin: 30px 0;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #c8e6d9;
            position: relative;
            overflow: hidden;
            z-index: 2;
        }

        .total-price::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%231d6a4f' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.1;
        }

        .total-price h3 {
            margin: 0;
            font-size: 2.4rem;
            color: #0a3c27;
            font-weight: 800;
            letter-spacing: 0.8px;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .barcode-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 25px 0;
            padding: 25px;
            background: #f8fdfb;
            border-radius: 16px;
            border: 1px solid #e0f2ec;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.04);
            position: relative;
            z-index: 2;
            transition: all 0.4s ease;
        }

        .barcode-section:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(29, 106, 79, 0.1);
        }

        .barcode {
            background: white;
            padding: 18px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #d4e8de;
        }

        .barcode img {
            max-width: 250px;
            display: block;
            height: auto;
            transition: transform 0.3s ease;
        }

        .barcode:hover img {
            transform: scale(1.03);
        }

        .ticket-code {
            margin-top: 18px;
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: 2.5px;
            color: #1d6a4f;
            background: #edf8f3;
            padding: 10px 25px;
            border-radius: 30px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
            font-family: 'Courier New', monospace;
        }

        .footer-note {
            text-align: center;
            color: #1d6a4f;
            font-size: 1.05rem;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e0f2ec;
            line-height: 1.7;
            position: relative;
            z-index: 2;
        }

        .footer-note p {
            margin-bottom: 15px;
        }

        .footer-note i {
            margin-right: 8px;
            color: #1d6a4f;
        }

        .print-button {
            text-align: center;
            margin-top: 35px;
            position: relative;
            z-index: 2;
        }

        .btn-print {
            background: linear-gradient(135deg, #1d6a4f 0%, #0a3c27 100%);
            border: none;
            color: white;
            padding: 16px 45px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.2rem;
            box-shadow: 0 8px 20px rgba(29, 106, 79, 0.35);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-print:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 30px rgba(29, 106, 79, 0.45);
        }

        .btn-print:active {
            transform: translateY(2px) scale(0.98);
        }

        .btn-print::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
            transition: 0.6s;
            z-index: -1;
        }

        .btn-print:hover::before {
            left: 100%;
        }

        .btn-secondary {
            background: #1d6a4f;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            margin-top: 20px;
            transition: all 0.4s ease;
            font-weight: 600;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(29, 106, 79, 0.25);
        }

        .btn-secondary:hover {
            background: #0a3c27;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(29, 106, 79, 0.35);
        }

        .security-features {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-top: 25px;
            color: #1d6a4f;
            font-size: 0.95rem;
            font-weight: 600;
            position: relative;
            z-index: 2;
        }

        .security-features span {
            background: #edf8f3;
            padding: 8px 20px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .security-features span:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.08);
            background: #e0f7ed;
        }

        .security-features i {
            color: #1d6a4f;
            font-size: 1.1rem;
        }

        .floating-icons {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .floating-icon {
            position: absolute;
            color: rgba(29, 106, 79, 0.1);
            font-size: 24px;
            animation: float 15s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }

            25% {
                transform: translate(20px, 40px) rotate(90deg);
            }

            50% {
                transform: translate(40px, 10px) rotate(180deg);
            }

            75% {
                transform: translate(10px, 30px) rotate(270deg);
            }

            100% {
                transform: translate(0, 0) rotate(360deg);
            }
        }

        /* Styling untuk cetak */
        @media print {
            body * {
                visibility: hidden;
            }

            .ticket-container,
            .ticket-container * {
                visibility: visible;
            }

            .ticket-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                box-shadow: none;
                transform: none !important;
                opacity: 1 !important;
            }

            .no-print {
                display: none;
            }

            .btn-print::before {
                display: none;
            }
        }

        @media (max-width: 992px) {
            .ticket-grid {
                grid-template-columns: 1fr;
            }

            .ticket-container {
                margin: 20px;
            }

            .ticket-header h1 {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 576px) {
            .ticket-header {
                padding: 20px 15px;
            }

            .logo-circle {
                width: 70px;
                height: 70px;
            }

            .ticket-header h1 {
                font-size: 1.8rem;
            }

            .ticket-header p {
                font-size: 1.1rem;
            }

            .ticket-body {
                padding: 25px 20px;
            }

            .total-price h3 {
                font-size: 1.8rem;
            }

            .btn-print {
                padding: 14px 35px;
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>
    <div class="ticket-container" id="ticket">
        <div class="floating-icons" id="floating-icons"></div>

        <div class="ticket-header">
            <div class="logo-container">
                <div class="logo-circle">
                    <i class="fas fa-bus"></i>
                </div>
                <div>
                    <h1>TIRTOPESAL TRAVEL</h1>
                    <p>Tiket Perjalanan Resmi</p>
                </div>
            </div>
        </div>
        <div class="ticket-body">
            <div class="watermark">TIRTOPESAL</div>

            <div class="ticket-grid">
                <div class="ticket-section">
                    <h3 class="section-title"><i class="fas fa-ticket-alt"></i> Detail Tiket</h3>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-hashtag"></i> Kode Tiket</span>
                        <span class="info-value">TRP<?= str_pad($pemesanan['id_pemesanan'], 6, '0', STR_PAD_LEFT) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-calendar-day"></i> Tanggal Pemesanan</span>
                        <span class="info-value"><?= date('d F Y H:i', strtotime($pemesanan['tanggal_pesan'])) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-calendar-alt"></i> Tanggal Berangkat</span>
                        <span class="info-value"><?= date('d F Y', strtotime($pemesanan['tanggal_berangkat'])) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-users"></i> Penumpang</span>
                        <span class="info-value"><?= $pemesanan['jumlah_penumpang'] ?> Orang</span>
                    </div>
                </div>

                <div class="ticket-section">
                    <h3 class="section-title"><i class="fas fa-route"></i> Rute Perjalanan</h3>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-location-dot"></i> Keberangkatan</span>
                        <span class="info-value"><?= $pemesanan['kota_asal'] ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-location-dot"></i> Tujuan</span>
                        <span class="info-value"><?= $pemesanan['kota_tujuan'] ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-car"></i> Kendaraan</span>
                        <span class="info-value"><?= $pemesanan['nama_mobil'] ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-tag"></i> Plat Nomor</span>
                        <span class="info-value"><?= $pemesanan['plat_nomor'] ?></span>
                    </div>
                </div>
            </div>

            <div class="ticket-grid">
                <div class="ticket-section">
                    <h3 class="section-title"><i class="fas fa-receipt"></i> Pembayaran</h3>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-money-bill-wave"></i> Metode</span>
                        <span class="info-value"><?= strtoupper($pemesanan['metode_pembayaran']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-circle-info"></i> Status</span>
                        <span class="info-value"><?= ucfirst($pemesanan['status']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-tag"></i> Harga Tiket</span>
                        <span class="info-value">Rp<?= number_format($pemesanan['tarif_mobil'] + $pemesanan['tarif_tujuan']) ?></span>
                    </div>
                </div>

                <div class="ticket-section">
                    <h3 class="section-title"><i class="fas fa-shield-alt"></i> Keamanan</h3>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-qrcode"></i> Verifikasi</span>
                        <span class="info-value">QR & Barcode</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-clock"></i> Berlaku</span>
                        <span class="info-value">Hingga Keberangkatan</span>
                    </div>
                </div>
            </div>

            <div class="total-price">
                <h3>Total Pembayaran: Rp<?= number_format($total_harga) ?></h3>
            </div>

            <div class="barcode-section">
                <div class="barcode">
                    <img src="https://barcode.tec-it.com/barcode.ashx?data=TRP<?= $pemesanan['id_pemesanan'] ?>&code=Code128&dpi=96&imagetype=Gif&rotation=0&color=%23000&bgcolor=%23fff&qunit=Mm&quiet=0" alt="Barcode Tiket">
                </div>
                <div class="ticket-code">TRP<?= str_pad($pemesanan['id_pemesanan'], 6, '0', STR_PAD_LEFT) ?></div>
            </div>
            <div class="print-button no-print">
                <button onclick="window.print()" class="btn-print">
                    <i class="fas fa-print"></i> Cetak Tiket
                </button>
                <a href="../pelanggan/dashboard.php" class="btn btn-secondary">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
            </div>

            <div class="footer-note">
                <p><i class="fas fa-exclamation-circle"></i> Harap tunjukkan tiket ini saat boarding. Tiket ini berlaku untuk <?= $pemesanan['jumlah_penumpang'] ?> penumpang.</p>
                <p><i class="fas fa-info-circle"></i> Pembatalan tiket dapat dilakukan maksimal 24 jam sebelum keberangkatan dengan biaya administrasi 20%.</p>
                <p><i class="fas fa-handshake"></i> Terima kasih telah menggunakan layanan TirtoPesal Travel.</p>
            </div>

            <div class="security-features">
                <span><i class="fas fa-lock"></i> Aman</span>
                <span><i class="fas fa-shield-alt"></i> Terverifikasi</span>
                <span><i class="fas fa-check-circle"></i> Resmi</span>
            </div>
        </div>
    </div>

    <script>
        // Animasi untuk tiket
        document.addEventListener('DOMContentLoaded', function() {
            const ticket = document.getElementById('ticket');
            const floatingIcons = document.getElementById('floating-icons');

            // Buat floating icons
            const icons = ['fa-bus', 'fa-ticket-alt', 'fa-route', 'fa-map-marker-alt',
                'fa-shield-alt', 'fa-qrcode', 'fa-calendar-alt', 'fa-users'
            ];

            for (let i = 0; i < 25; i++) {
                const icon = document.createElement('div');
                icon.className = 'floating-icon';
                icon.innerHTML = `<i class="fas ${icons[Math.floor(Math.random() * icons.length)]}"></i>`;
                icon.style.left = `${Math.random() * 100}%`;
                icon.style.top = `${Math.random() * 100}%`;
                icon.style.animationDuration = `${15 + Math.random() * 20}s`;
                icon.style.opacity = `${0.05 + Math.random() * 0.1}`;
                icon.style.fontSize = `${14 + Math.random() * 20}px`;
                floatingIcons.appendChild(icon);
            }

            // Animasi masuk tiket
            setTimeout(() => {
                ticket.classList.add('show');

                // Animasi untuk elemen dalam tiket secara bertahap
                const animatedElements = document.querySelectorAll('.ticket-section, .total-price, .barcode-section, .footer-note, .security-features, .print-button');

                animatedElements.forEach((el, index) => {
                    setTimeout(() => {
                        el.style.opacity = '1';
                        el.style.transform = 'translateY(0)';
                    }, index * 150);
                });

                // Efek hover untuk logo
                const logoCircle = document.querySelector('.logo-circle');
                logoCircle.addEventListener('mouseenter', () => {
                    logoCircle.style.transform = 'scale(1.1) rotate(5deg)';
                    logoCircle.style.boxShadow = '0 15px 30px rgba(0, 0, 0, 0.2)';
                });

                logoCircle.addEventListener('mouseleave', () => {
                    logoCircle.style.transform = 'scale(1) rotate(0)';
                    logoCircle.style.boxShadow = '0 8px 20px rgba(0, 0, 0, 0.15)';
                });

                // Efek hover untuk section
                const sections = document.querySelectorAll('.ticket-section');
                sections.forEach(section => {
                    section.addEventListener('mouseenter', () => {
                        section.style.transform = 'translateY(-8px)';
                        section.style.boxShadow = '0 15px 30px rgba(29, 106, 79, 0.2)';
                    });

                    section.addEventListener('mouseleave', () => {
                        section.style.transform = 'translateY(0)';
                        section.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.05)';
                    });
                });

                // Animasi untuk info item
                const infoItems = document.querySelectorAll('.info-item');
                infoItems.forEach((item, index) => {
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, 800 + index * 100);
                });

            }, 200);

            // Animasi tombol cetak
            const printBtn = document.querySelector('.btn-print');
            printBtn.addEventListener('mouseenter', () => {
                printBtn.style.transform = 'translateY(-5px) scale(1.05)';
            });

            printBtn.addEventListener('mouseleave', () => {
                printBtn.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>

</html>