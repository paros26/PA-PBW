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
                                    <?php if(isset($_SESSION['user'])): ?>
                                        <button class="btn btn-primary" style="width: 100%;" 
                                                onclick='openBookingModal(<?= json_encode($jetSki); ?>)'>
                                            Pesan Paket
                                        </button>
                                    <?php else: ?>
                                        <a href="<?= BASEURL; ?>/user_login" class="btn btn-primary" style="width: 100%; text-decoration: none; display: inline-block; text-align: center;">
                                            Pesan Paket
                                        </a>
                                    <?php endif; ?>
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

    <!-- Success Modal -->
    <div id="successModal" class="modal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.85); backdrop-filter: blur(10px); align-items: center; justify-content: center;">
        <div class="modal-content" style="background: #111; border: 1px solid var(--primary); border-radius: 30px; max-width: 450px; width: 90%; text-align: center; padding: 3rem 2rem; box-shadow: 0 25px 50px rgba(0,0,0,0.5), 0 0 30px rgba(255,140,0,0.1); position: relative; animation: modalSlideUp 0.4s ease-out;">
            
            <!-- Close Button -->
            <button onclick="document.getElementById('successModal').style.display='none'" 
                    style="position: absolute; top: 20px; right: 20px; background: none; border: none; color: #555; font-size: 1.5rem; cursor: pointer; transition: 0.3s;"
                    onmouseover="this.style.color='white'" onmouseout="this.style.color='#555'">
                <i class="bi bi-x-lg"></i>
            </button>

            <!-- Success Icon -->
            <div style="width: 90px; height: 90px; background: rgba(255, 140, 0, 0.1); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; border: 1px solid rgba(255, 140, 0, 0.2);">
                <i class="bi bi-check2-circle" style="font-size: 3.5rem;"></i>
            </div>
            
            <h2 style="color: white; margin-bottom: 0.5rem; font-weight: 800; letter-spacing: -1px;">Pesanan Diterima!</h2>
            <p style="color: #888; font-size: 0.9rem; margin-bottom: 2rem;">Silakan simpan token ini dan konfirmasi ke admin melalui WhatsApp.</p>
            
            <!-- Token Display -->
            <div style="background: rgba(255, 255, 255, 0.03); border: 2px dashed rgba(255, 140, 0, 0.3); border-radius: 20px; padding: 1.5rem; margin-bottom: 2rem; position: relative;">
                <span style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: #111; padding: 0 15px; color: var(--primary); font-size: 0.7rem; font-weight: 800; letter-spacing: 2px; text-transform: uppercase;">Token Transaksi</span>
                <h1 id="displayToken" style="color: white; font-family: 'Monaco', monospace; font-weight: 900; letter-spacing: 6px; margin: 0; font-size: 2.2rem;">-</h1>
            </div>

            <!-- Detail List -->
            <div id="displayDetails" style="text-align: left; background: rgba(0,0,0,0.3); padding: 1.5rem; border-radius: 18px; margin-bottom: 2rem; font-size: 0.85rem; border: 1px solid rgba(255,255,255,0.05);">
                <!-- Details injected via JS -->
            </div>

            <button id="btnProceedWA" class="btn btn-primary" style="width: 100%; padding: 1.2rem; border-radius: 100px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; box-shadow: 0 10px 20px rgba(255, 140, 0, 0.2);">
                <i class="bi bi-whatsapp me-2"></i> Kirim Konfirmasi
            </button>
        </div>
    </div>

    <style>
        @keyframes modalSlideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .cursor-pointer { cursor: pointer; }
    </style>
