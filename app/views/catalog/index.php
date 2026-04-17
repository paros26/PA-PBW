    <!-- Main Content -->
    <main class="page-content">
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">Paket Rental Jet Ski</h1>
                <p class="page-subtitle">Pilih paket petualangan terbaik untuk menjelajahi Sungai Mahakam</p>
            </div>

            <div class="catalog-grid" id="catalogGrid">
                <?php foreach ($data['jetskis'] as $jetSki) : ?>
                    <div class="catalog-item">
                        <div class="catalog-item-header">
                            <img src="<?= BASEURL; ?>/img/jetski/<?= $jetSki['image_url']; ?>" alt="<?= $jetSki['name']; ?>" class="catalog-image" 
                                 onerror="this.src='https://via.placeholder.com/400x250?text=No+Image'">
                            <span class="badge <?= $jetSki['is_available'] ? 'badge-green' : 'badge-red'; ?>">
                                <?= $jetSki['is_available'] ? 'Tersedia' : 'Penuh'; ?>
                            </span>
                        </div>
                        <div class="catalog-content">
                            <div class="package-meta">
                                <span class="rider-badge">
                                    <?= ($jetSki['rider_type'] == 'single') ? '👤 Single Rider' : '👥 Couple Rider'; ?>
                                </span>
                            </div>
                            <h3 class="catalog-title"><?= $jetSki['name']; ?></h3>
                            
                            <div class="route-info" style="margin-bottom: 1rem;">
                                <p style="color: var(--primary); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">
                                    📍 Rute Perjalanan:
                                </p>
                                <p style="color: #eee; font-size: 0.95rem;"><?= $jetSki['route'] ?: 'Rute menyesuaikan'; ?></p>
                            </div>

                            <p class="catalog-description"><?= $jetSki['description']; ?></p>
                            
                            <div class="catalog-price">
                                <p class="catalog-price-label">Harga Paket</p>
                                <p class="catalog-price-amount">
                                    Rp <?= number_format($jetSki['price_per_hour'], 0, ',', '.'); ?>
                                    <span class="catalog-price-unit">/sesi</span>
                                </p>
                            </div>
                            
                            <div style="margin-top: 1.5rem;">
                                <?php if($jetSki['is_available']): ?>
                                    <button class="btn btn-primary" style="width: 100%;" 
                                            onclick='openBookingModal(<?= json_encode($jetSki); ?>)'>
                                        Pesan Paket
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-outline" style="width: 100%; cursor: not-allowed;" disabled>
                                        Paket Tidak Tersedia
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <!-- Booking Modal for User -->
    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Formulir Penyewaan</h2>
                <button class="modal-close" onclick="closeModal('bookingModal')">&times;</button>
            </div>
            <form id="bookingForm">
                <input type="hidden" id="bookingJetSkiId" name="jetski_id">
                
                <div class="form-group">
                    <label>Paket Rental</label>
                    <input type="text" id="bookingJetSkiName" readonly style="background: rgba(255,255,255,0.05); color: white; font-weight: 700;">
                    <p id="bookingPackageDetails" style="font-size: 0.85rem; color: var(--primary); margin-top: 5px; font-weight: 600;"></p>
                </div>

                <div class="form-group">
                    <label for="customer_name">Nama Lengkap *</label>
                    <input type="text" id="customer_name" name="customer_name" placeholder="Masukkan nama Anda" required>
                </div>

                <div class="form-group">
                    <label for="customer_phone">Nomor WhatsApp (Maks 13 Angka) *</label>
                    <input type="text" id="customer_phone" name="customer_phone" 
                           placeholder="Contoh: 08123456789" pattern="[0-9]{10,13}" title="Hanya boleh angka, 10-13 digit" 
                           maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="rental_date">Tanggal Sewa *</label>
                        <input type="date" id="rental_date" name="rental_date" required>
                    </div>
                    <div class="form-group">
                        <label for="duration">Jumlah Sesi *</label>
                        <input type="number" id="duration" name="duration" min="1" value="1" required>
                    </div>
                </div>

                <div class="price-preview">
                    <p>Estimasi Total Paket: <strong id="bookingTotalPriceDisplay">Rp 0</strong></p>
                    <input type="hidden" id="bookingTotalPrice" name="total_price">
                    <input type="hidden" name="status" value="active">
                </div>

                <p style="font-size: 0.85rem; color: #666; margin-bottom: 1.5rem;">
                    * Setelah menekan tombol konfirmasi, data Anda akan tercatat dan silakan hubungi admin melalui WhatsApp untuk penyelesaian pembayaran.
                </p>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('bookingModal')">Batal</button>
                    <button type="submit" class="btn btn-primary">Konfirmasi Penyewaan</button>
                </div>
            </form>
        </div>
    </div>
