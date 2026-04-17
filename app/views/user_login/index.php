    <div class="login-wrapper">
        <!-- Decorative Background -->
        <div class="login-bg-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>

        <div class="login-card">
            <div class="login-header">
                <div class="login-brand">
                    <svg class="logo-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                    <span>Jetski Mahakam</span>
                </div>
                <h1>Selamat Datang</h1>
                <p>Masuk untuk mengelola petualangan jet ski Anda</p>
            </div>

            <?php if (isset($_GET['registered'])) : ?>
                <div class="login-alert success" style="background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2); color: #10b981;">
                    <div class="alert-content">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <span>Pendaftaran berhasil! Silakan masuk.</span>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])) : ?>
                <div class="login-alert">
                    <div class="alert-content">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <span>
                            <?php 
                                if($_GET['error'] == 'unauthorized') echo "Akses ditolak! Admin tidak boleh login di sini.";
                                else echo "Username atau password salah!";
                            ?>
                        </span>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?= BASEURL; ?>/user_login/process" method="POST" class="login-form">
                <div class="input-group">
                    <label for="username">Username</label>
                    <div class="input-field">
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <input type="text" id="username" name="username" placeholder="Masukkan username" required autofocus>
                    </div>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-field">
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn-login-submit">
                    <span>Masuk ke Akun</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </button>
                
                <a href="<?= BASEURL; ?>/register" class="btn-register-link">
                    Belum punya akun? <span>Daftar Sekarang</span>
                </a>
            </form>

            <div class="login-footer">
                <div class="footer-divider">
                    <span>Atau</span>
                </div>
                <div class="footer-links">
                    <a href="<?= BASEURL; ?>" class="btn-back-home">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        Beranda
                    </a>
                    <div class="register-text">
                        Butuh bantuan? <a href="https://wa.me/628123456789" target="_blank">Hubungi CS</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
