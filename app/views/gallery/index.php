    <!-- Main Content -->
    <main class="page-content">
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">Galeri & Dokumentasi</h1>
                <p class="page-subtitle">Lihat momen-momen seru dan pengalaman pelanggan kami</p>
            </div>

            <div class="gallery-grid" id="galleryGrid">
                <?php foreach ($data['gallery'] as $item) : ?>
                    <div class="gallery-item">
                        <img src="<?= BASEURL; ?>/img/gallery/<?= $item['image_url']; ?>" alt="<?= $item['caption']; ?>" class="gallery-image"
                             onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'">
                        <div class="gallery-overlay">
                            <p class="gallery-caption"><?= $item['caption']; ?></p>
                            <p class="gallery-date"><?= date('d M Y', strtotime($item['upload_date'])); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Info Section -->
            <div class="card stats-card">
                <h2 class="section-title">Pengalaman Pelanggan Kami</h2>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <p>Pelanggan Puas</p>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">3</div>
                        <p>Unit Jet Ski Premium</p>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <p>Tingkat Keamanan</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
