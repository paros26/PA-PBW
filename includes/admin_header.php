<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Dashboard Admin - Jetski Mahakam'; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header -->
    <header class="admin-header">
        <div class="admin-header-content">
            <div>
                <h1>Dashboard Admin</h1>
                <p>Jetski Mahakam Management System</p>
            </div>
            <button class="btn btn-outline" id="logoutBtn">
                <span class="logout-icon">🚪</span> Logout
            </button>
        </div>
    </header>

    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <nav class="admin-nav">
                <button class="admin-nav-btn active" data-tab="jetski">
                    <span class="nav-icon">🌊</span> Katalog Jet Ski
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
