<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?></title>
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/styles.css?v=1.1">
    <script>
        const BASEURL = '<?= BASEURL; ?>';
    </script>
</head>
<body>
    <!-- Header -->
    <header class="admin-header">
        <div class="admin-header-content">
            <div>
                <h1>Dashboard Admin</h1>
                <p>Jetski Mahakam Management System</p>
            </div>
            <a href="<?= BASEURL; ?>/login_admin/logout" class="btn btn-outline" id="logoutBtn">
                <span class="logout-icon">🚪</span> Logout
            </a>
        </div>
    </header>

    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <nav class="admin-nav">
                <button class="admin-nav-btn active" data-tab="jetski">
                    <span class="nav-icon">🌊</span> Kelola Paket Rental
                </button>
                <button class="admin-nav-btn" data-tab="rentals">
                    <span class="nav-icon">📝</span> Transaksi Sewa
                </button>
                <button class="admin-nav-btn" data-tab="income">
                    <span class="nav-icon">💰</span> Laporan Income
                </button>
                <button class="admin-nav-btn" data-tab="gallery">
                    <span class="nav-icon">🖼️</span> Kelola Galeri
                </button>
            </nav>
        </aside>
