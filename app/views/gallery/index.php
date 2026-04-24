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
        </div>
    </main>
