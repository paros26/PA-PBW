<?php
if (!isset($page_title)) {
    $page_title = "Jetski Mahakam";
}
if (!isset($active_page)) {
    $active_page = "index";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">
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
                <a href="index.php" class="nav-link <?php echo ($active_page == 'index') ? 'active' : ''; ?>">Beranda</a>
                <a href="about.php" class="nav-link <?php echo ($active_page == 'about') ? 'active' : ''; ?>">Tentang Kami</a>
                <a href="catalog.php" class="nav-link <?php echo ($active_page == 'catalog') ? 'active' : ''; ?>">Katalog</a>
                <a href="gallery.php" class="nav-link <?php echo ($active_page == 'gallery') ? 'active' : ''; ?>">Galeri</a>
                <a href="login.php" class="btn-outline">Admin Login</a>
            </div>
        </div>
    </nav>
