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
                <h1>Daftar Akun</h1>
                <p>Bergabunglah untuk mulai menjelajahi Mahakam</p>
            </div>

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
                                if($_GET['error'] == 'password') echo "Konfirmasi password tidak cocok!";
                                elseif($_GET['error'] == 'exists') echo "Username sudah terdaftar!";
                                else echo "Gagal melakukan pendaftaran!";
                            ?>
                        </span>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?= BASEURL; ?>/register/process" method="POST" class="login-form">
                <div class="input-group">
                    <label for="username">Username</label>
                    <div class="input-field">
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <input type="text" id="username" name="username" placeholder="Buat username unik" required autofocus>
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
                        <input type="password" id="password" name="password" placeholder="Buat password aman" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <div class="input-field">
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <polyline points="17 11 19 13 23 9"></polyline>
                            </svg>
                        </div>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Ulangi password" required>
                    </div>
                </div>

                <button type="submit" class="btn-login-submit">
                    <span>Daftar Akun Baru</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                </button>
            </form>

            <div class="login-footer">
                <div class="footer-divider">
                    <span>Sudah punya akun?</span>
                </div>
                <div class="footer-links">
                    <a href="<?= BASEURL; ?>/user_login" class="btn-back-home">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                            <polyline points="10 17 5 12 10 7"></polyline>
                            <line x1="15" y1="12" x2="5" y2="12"></line>
                        </svg>
                        Login Pelanggan
                    </a>
                </div>
            </div>
        </div>
    </div>