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
                    <span>Admin Panel</span>
                </div>
                <h1>Login Admin</h1>
                <p>Masuk ke sistem manajemen Jetski Mahakam</p>
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
                                if($_GET['error'] == 'unauthorized') echo "Akses ditolak! Anda bukan administrator.";
                                else echo "Username atau password salah!";
                            ?>
                        </span>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?= BASEURL; ?>/login_admin/process" method="POST" class="login-form">
                <div class="input-group">
                    <label for="username">Username Admin</label>
                    <div class="input-field">
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <input type="text" id="username" name="username" placeholder="Username admin" required autofocus>
                    </div>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-field position-relative">
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password', this)" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #666; cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 0; z-index: 10;">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </div>
                </div>

                <script>
                    function togglePassword(inputId, btn) {
                        const input = document.getElementById(inputId);
                        const icon = btn.querySelector('i');
                        if (input.type === 'password') {
                            input.type = 'text';
                            icon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
                        } else {
                            input.type = 'password';
                            icon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
                        }
                    }
                </script>

                <button type="submit" class="btn-login-submit">
                    <span>Masuk sebagai Admin</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </button>
            </form>

            <div class="login-footer">
                <div class="footer-divider">
                    <span>Kembali</span>
                </div>
                <div class="footer-links">
                    <a href="<?= BASEURL; ?>" class="btn-back-home">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>