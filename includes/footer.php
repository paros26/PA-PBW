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
                    <a href="index.php">Beranda</a>
                    <a href="about.php">Tentang Kami</a>
                    <a href="catalog.php">Katalog</a>
                    <a href="gallery.php">Galeri</a>
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
                <p>&copy; <?php echo date("Y"); ?> Jetski Mahakam. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="app.js"></script>
    <?php if (isset($extra_scripts)) echo $extra_scripts; ?>
</body>
</html>
