    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo">
                        <svg class="logo-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        <span>Jetski Mahakam</span>
                    </div>
                    <p>Penyedia jasa penyewaan jet ski terbaik di Sungai Mahakam, Kalimantan Timur.</p>
                </div>

                <div class="footer-col">
                    <h3>Navigasi</h3>
                    <a href="<?= BASEURL; ?>">Beranda</a>
                    <a href="<?= BASEURL; ?>/about">Tentang Kami</a>
                    <a href="<?= BASEURL; ?>/catalog">Katalog</a>
                    <a href="<?= BASEURL; ?>/gallery">Galeri</a>
                </div>

                <div class="footer-col">
                    <h3>Kontak</h3>
                    <p>Jl. Tepi Sungai Mahakam No. 123</p>
                    <p>Samarinda, Kalimantan Timur</p>
                    <p>Telepon: +62 812-3456-7890</p>
                    <p>Email: info@jetskimahakam.com</p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; <?= date("Y"); ?> Jetski Mahakam. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="<?= BASEURL; ?>/js/app.js"></script>
    <?php if (isset($data['extra_scripts'])) : ?>
        <?php foreach ($data['extra_scripts'] as $script) : ?>
            <script src="<?= BASEURL; ?>/js/<?= $script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
