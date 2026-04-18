<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?></title>
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/styles.css?v=1.1">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="<?= BASEURL; ?>" class="logo">
                <svg class="logo-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
                <span>Jetski Mahakam</span>
            </a>

            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="nav-links" id="navLinks">
                <a href="<?= BASEURL; ?>" class="nav-link <?= ($data['active'] == 'index') ? 'active' : ''; ?>">Beranda</a>
                <a href="<?= BASEURL; ?>/about" class="nav-link <?= ($data['active'] == 'about') ? 'active' : ''; ?>">Tentang Kami</a>
                <a href="<?= BASEURL; ?>/catalog" class="nav-link <?= ($data['active'] == 'catalog') ? 'active' : ''; ?>">Katalog</a>
                <a href="<?= BASEURL; ?>/gallery" class="nav-link <?= ($data['active'] == 'gallery') ? 'active' : ''; ?>">Galeri</a>
                <a href="<?= BASEURL; ?>/login" class="btn-nav-login">Login Pengguna</a>
            </div>
        </div>
    </nav>
