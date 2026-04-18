    <style>
        :root {
            --primary: #f97316;
            --primary-hover: #ea580c;
            --secondary: #1e3a8a;
            --bg-gradient: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            --glass-bg: rgba(255, 255, 255, 0.98);
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-gradient);
            padding: 20px;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        .login-card {
            background: var(--glass-bg);
            width: 100%;
            max-width: 420px;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
            border-top: 5px solid var(--primary);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            font-size: 28px;
            color: var(--secondary);
            margin-bottom: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-header p {
            color: #64748b;
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--secondary);
            font-weight: 700;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.2s ease;
            box-sizing: border-box;
            background: #f8fafc;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
            background: #fff;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 10px;
            text-transform: uppercase;
        }

        .btn-login:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .login-footer {
            margin-top: 25px;
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }

        .login-footer a {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 700;
        }

        .login-footer a:hover {
            color: var(--primary);
            text-decoration: underline;
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
            font-weight: 600;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .back-home {
            display: inline-block;
            margin-top: 20px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .back-home:hover {
            color: var(--secondary);
        }
    </style>

    <div class="login-page">
        <div class="login-card">
            <div class="login-header">
                <h1>JETSKI MAHAKAM</h1>
                <p>Buat akun baru Anda</p>
            </div>

            <?php if (isset($_GET['error'])) : ?>
                <div class="alert alert-danger">
                    <?php 
                        if($_GET['error'] == 'username_exists') echo 'Username sudah digunakan!';
                        else echo 'Registrasi gagal, silakan coba lagi.';
                    ?>
                </div>
            <?php endif; ?>

            <form action="<?= BASEURL; ?>/login/processRegister" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Pilih username" required autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" required minlength="6">
                </div>

                <button type="submit" class="btn-login">Daftar Akun</button>
            </form>
            
            <div class="login-footer">
                <p>Sudah punya akun? <a href="<?= BASEURL; ?>/login">Login di sini</a></p>
                <a href="<?= BASEURL; ?>" class="back-home">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
