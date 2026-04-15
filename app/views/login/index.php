    <!-- Main Content -->
    <main class="page-content">
        <div class="login-container">
            <div class="card login-card">
                <div class="card-header center">
                    <h1>Admin Login</h1>
                    <p>Masukkan kredensial Anda untuk mengakses dashboard</p>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['error'])) : ?>
                        <div class="alert alert-danger" style="color: #dc2626; background: #fee2e2; padding: 10px; border-radius: 6px; margin-bottom: 20px;">
                            Username atau password salah!
                        </div>
                    <?php endif; ?>
                    <form action="<?= BASEURL; ?>/login/process" method="POST">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" placeholder="admin" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="••••••••" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Masuk ke Dashboard</button>
                    </form>
                    <div class="login-footer">
                        <a href="<?= BASEURL; ?>" class="back-link">← Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
