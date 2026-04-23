<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/styles.css?v=1.6">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        const BASEURL = '<?= BASEURL; ?>';
    </script>
    <script type="importmap">
    {
        "imports": {
            "vue": "<?= BASEURL; ?>/js/vendor/vue.js"
        }
    }
    </script>
    <style>
        :root {
            --primary: #ff8c00;
            --primary-gradient: linear-gradient(135deg, #ff8c00 0%, #ff5e00 100%);
            --black: #000000;
            --dark-bg: #0a0a0a;
            --card-bg: #141414;
            --border: rgba(255, 140, 0, 0.15);
            --text: #ffffff;
            --text-muted: #a0a0a0;
            --sidebar-width: 280px;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text);
            font-family: 'Inter', -apple-system, sans-serif;
            overflow-x: hidden;
        }

        /* Modern Sidebar */
        .admin-sidebar {
            width: var(--sidebar-width);
            background-color: var(--black);
            border-right: 1px solid var(--border);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 1.5rem;
        }

        .sidebar-brand {
            padding-bottom: 2rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .admin-nav-btn {
            border: none !important;
            color: var(--text-muted) !important;
            padding: 12px 16px !important;
            transition: all 0.2s;
            background: transparent !important;
            text-align: left;
            width: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
            border-radius: 12px !important;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .admin-nav-btn:hover {
            color: white !important;
            background: rgba(255, 140, 0, 0.08) !important;
            transform: translateX(5px);
        }

        .admin-nav-btn.active {
            background: var(--primary-gradient) !important;
            color: white !important;
            box-shadow: 0 8px 20px rgba(255, 140, 0, 0.25);
        }

        /* Top Header */
        .admin-main-wrapper {
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
            min-height: 100vh;
        }

        .top-navbar {
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        /* Premium Cards */
        .card {
            background: var(--card-bg) !important;
            border: 1px solid var(--border) !important;
            border-radius: 20px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important;
            overflow: hidden;
        }

        .card-header {
            background: rgba(255,255,255,0.02) !important;
            border-bottom: 1px solid var(--border) !important;
            padding: 1.25rem 1.5rem !important;
        }

        /* Stats Cards */
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: 0.3s;
            color: white !important;
        }

        .stat-card .text-muted {
            color: white !important;
        }

        /* Modal Text Visibility */
        .modal-content .text-muted,
        .modal-content .x-small,
        .modal-content .small,
        .modal-content .field-icon {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .modal-content label {
            color: var(--primary) !important;
            opacity: 1 !important;
        }

        .modal-content input::placeholder,
        .modal-content textarea::placeholder {
            color: rgba(255, 255, 255, 0.4) !important;
        }

        .stat-card:hover {
            border-color: var(--primary);
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: rgba(255, 140, 0, 0.1);
            color: var(--primary);
        }

        /* Table Styling */
        .table {
            color: var(--text) !important;
            margin-bottom: 0;
            background-color: var(--black) !important;
        }

        .table thead th {
            background: #000000 !important;
            color: #ffffff !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 1.2rem 1rem;
            border-bottom: 1px solid var(--border);
        }

        .table tbody td {
            background-color: #000000 !important;
            padding: 1.5rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(255,140,0,0.05);
        }

        .table-responsive {
            background-color: #000000 !important;
            border-radius: 20px;
        }

        .card .table-responsive {
            border: none;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--dark-bg); }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary); }

        /* Premium Modal Styling */
        .modal-backdrop {
            backdrop-filter: blur(8px);
            background-color: rgba(0, 0, 0, 0.7) !important;
        }

        .modal-content {
            background: rgba(20, 20, 20, 0.9) !important;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 140, 0, 0.3) !important;
            border-radius: 28px !important;
            box-shadow: 0 25px 50px rgba(0,0,0,0.8), 0 0 20px rgba(255, 140, 0, 0.1) !important;
        }

        .modal-header {
            border-bottom: 1px solid rgba(255,255,255,0.05) !important;
            padding: 2rem 2rem 1.5rem !important;
        }

        .modal-footer {
            border-top: 1px solid rgba(255,255,255,0.05) !important;
            padding: 1.5rem 2rem 2rem !important;
        }

        /* Modern Form Control inside Modal */
        .modal-body .form-label {
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 0.6rem;
        }

        .modal-body .form-control, 
        .modal-body .form-select {
            background: #1a1a1a !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 14px !important;
            padding: 0.8rem 1.2rem !important;
            color: white !important;
            transition: 0.3s;
        }

        .modal-body .form-control:focus, 
        .modal-body .form-select:focus {
            background: #222 !important;
            border-color: var(--primary) !important;
            box-shadow: 0 0 15px rgba(255, 140, 0, 0.15) !important;
        }

        /* Refined Modal Layout */
        .modal-md-custom {
            max-width: 550px;
            margin: 1.75rem auto;
        }

        .modal-content {
            background: #0f0f0f !important;
            border: 1px solid rgba(255, 140, 0, 0.2) !important;
            box-shadow: 0 25px 80px rgba(0,0,0,0.9) !important;
            border-radius: 24px !important;
            max-height: calc(100vh - 3.5rem);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Fix for scroll when form is a child of modal-content */
        .modal-content form {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            overflow: hidden;
        }

        .modal-header-premium {
            border-bottom: 1px solid rgba(255,255,255,0.05);
            flex-shrink: 0;
        }

        .modal-body {
            overflow-y: auto;
            flex-grow: 1;
            scrollbar-width: thin;
            scrollbar-color: var(--primary) #1a1a1a;
            padding-right: 8px; /* Space for scrollbar */
        }

        .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #1a1a1a;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        .modal-footer {
            border-top: 1px solid rgba(255,255,255,0.05);
            flex-shrink: 0;
            background: #0f0f0f !important;
            padding: 1.5rem 2rem !important;
            z-index: 10;
        }

        /* Refined Premium Form Styling */
        .floating-field {
            position: relative;
            background: rgba(255, 255, 255, 0.015);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 0.85rem 1.4rem;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            display: flex;
            flex-direction: column;
        }

        .floating-field:hover {
            background: rgba(255, 255, 255, 0.03);
            border-color: rgba(255, 140, 0, 0.2);
        }

        .floating-field:focus-within {
            background: rgba(255, 140, 0, 0.04);
            border-color: var(--primary);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 15px rgba(255, 140, 0, 0.05);
            transform: translateY(-2px);
        }

        .floating-field label {
            font-size: 0.6rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--primary);
            margin-bottom: 6px;
            opacity: 0.85;
            display: block;
        }

        .field-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .field-icon {
            color: rgba(255, 255, 255, 0.15);
            font-size: 1.2rem;
            transition: 0.3s;
        }

        .floating-field:focus-within .field-icon {
            color: var(--primary);
            transform: scale(1.1);
        }

        .floating-field input, 
        .floating-field textarea {
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
            color: #ffffff !important;
            font-size: 0.95rem;
            font-weight: 500;
            width: 100%;
            outline: none !important;
            box-shadow: none !important;
        }

        .floating-field select {
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
            color: var(--primary) !important;
            font-size: 0.95rem;
            font-weight: 600;
            width: 100%;
            outline: none !important;
            box-shadow: none !important;
            cursor: pointer;
        }

        .floating-field select option {
            background-color: #1a1a1a !important;
            color: white !important;
        }

        /* Fix for Chrome Autofill background */
        .floating-field input:-webkit-autofill,
        .floating-field input:-webkit-autofill:hover, 
        .floating-field input:-webkit-autofill:focus {
            -webkit-text-fill-color: #ffffff !important;
            -webkit-box-shadow: 0 0 0px 1000px #1a1a1a inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        /* Clean Select Arrows */
        .floating-field select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23ff8c00' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right center;
            padding-right: 20px !important;
        }

        .floating-field input[type="date"] {
            color-scheme: dark;
            cursor: pointer;
        }

        /* Improved Switch UI */
        .publication-card {
            background: rgba(255, 255, 255, 0.015);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 1.5rem;
            transition: 0.3s;
        }

        .publication-card:hover {
            background: rgba(255, 255, 255, 0.025);
            border-color: rgba(255, 255, 255, 0.1);
        }

        /* Status Pill Switch */
        .status-pill-switch {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 100px;
            padding: 6px;
            display: inline-flex;
            gap: 4px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .status-pill-item {
            padding: 8px 20px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        .status-pill-item.active.available {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.3);
        }

        .status-pill-item.active.full {
            background: #333;
            color: #888;
        }

        @media (max-width: 992px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .admin-main-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div id="adminApp">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="sidebar">
            <div class="sidebar-brand d-flex align-items-center gap-3">
                <div class="brand-logo" style="width: 45px; height: 45px; background: var(--primary-gradient); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-water text-white fs-4"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">MAHAKAM</h5>
                    <span class="x-small text-primary fw-bold tracking-widest" style="font-size: 0.65rem; letter-spacing: 2px;">ADMIN DASHBOARD</span>
                </div>
            </div>
            
            <nav class="nav flex-column mt-4">
                <button class="admin-nav-btn <?= ($data['active_tab'] == 'jetski') ? 'active' : ''; ?>" data-tab="jetski">
                    <i class="bi bi-grid-1x2-fill"></i> Paket Rental
                </button>
                <button class="admin-nav-btn <?= ($data['active_tab'] == 'rentals') ? 'active' : ''; ?>" data-tab="rentals">
                    <i class="bi bi-receipt-cutoff"></i> Transaksi Sewa
                </button>
                <button class="admin-nav-btn <?= ($data['active_tab'] == 'income') ? 'active' : ''; ?>" data-tab="income">
                    <i class="bi bi-graph-up-arrow"></i> Laporan Income
                </button>
                <button class="admin-nav-btn <?= ($data['active_tab'] == 'gallery') ? 'active' : ''; ?>" data-tab="gallery">
                    <i class="bi bi-images"></i> Kelola Galeri
                </button>
                
                <div class="mt-auto pt-5">
                    <a href="<?= BASEURL; ?>/login_admin/logout" class="admin-nav-btn text-danger">
                        <i class="bi bi-box-arrow-left"></i> Logout
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Wrapper -->
        <div class="admin-main-wrapper">
            <!-- Top Navbar -->
            <header class="top-navbar d-flex justify-content-between align-items-center">
                <button class="btn btn-dark d-lg-none border-secondary" id="toggleSidebar">
                    <i class="bi bi-list fs-5"></i>
                </button>
                
                <div class="d-none d-md-flex align-items-center gap-2 text-muted small">
                    <i class="bi bi-calendar3"></i>
                    <span><?= date('l, d F Y'); ?></span>
                </div>

                <div class="user-profile d-flex align-items-center gap-3">
                    <div class="text-end d-none d-sm-block">
                        <p class="mb-0 small fw-bold">Administrator</p>
                        <span class="x-small text-primary" style="font-size: 0.7rem;">Online</span>
                    </div>
                    <div class="avatar" style="width: 40px; height: 40px; background: #222; border: 1px solid var(--primary); border-radius: 50%; overflow: hidden;">
                        <img src="<?= BASEURL; ?>/../assets/img/logo jetski mahakam.jpeg" alt="Admin" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
            </header>



