<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?></title>
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/styles.css?v=1.1">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script>
        const BASEURL = '<?= BASEURL; ?>';
    </script>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="<?= BASEURL; ?>" class="logo" style="display: flex; align-items: center; gap: 0.75rem;">
                <img src="<?= BASEURL; ?>/assets/img/logo jetski mahakam.jpeg" alt="Logo" style="height: 50px; width: 50px; border-radius: 4px; object-fit: cover;">
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
                
                <?php if (isset($_SESSION['user'])) : ?>
                    <div class="user-nav-info">
                        <span class="welcome-text">Halo, <?= $_SESSION['user_name']; ?></span>
                        <a href="<?= BASEURL; ?>/user_login/logout" class="btn-nav-login">Logout</a>
                    </div>
                <?php else : ?>
                    <a href="<?= BASEURL; ?>/user_login" class="btn-nav-login <?= ($data['active'] == 'user_login' || $data['active'] == 'login') ? 'active' : ''; ?>">Login Pelanggan</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

