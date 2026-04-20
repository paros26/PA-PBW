        <!-- Main Content -->
        <main class="admin-main">
            <!-- Jet Ski Management Tab -->
            <div id="jetski-tab" class="tab-content <?= ($data['active_tab'] == 'jetski') ? 'active' : ''; ?>">
                <div class="tab-header">
                    <h2>Kelola Paket Rental</h2>
                    <button class="btn btn-primary" onclick="openJetSkiModal()">
                        <span>➕</span> Tambah Paket Baru
                    </button>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-container">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Gambar</th>
                                        <th>Nama Paket</th>
                                        <th>Tipe Rider</th>
                                        <th>Rute</th>
                                        <th>Harga/Sesi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="jetSkiTableBody">
                                    <!-- Data will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rental Management Tab -->
            <div id="rentals-tab" class="tab-content <?= ($data['active_tab'] == 'rentals') ? 'active' : ''; ?>">
                <div class="tab-header">
                    <h2>Kelola Transaksi Sewa</h2>
                    <button class="btn btn-primary" onclick="openRentalModal()">
                        <span>➕</span> Tambah Transaksi
                    </button>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-container">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Bukti</th>
                                        <th>Token</th>
                                        <th>Jet Ski</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Telepon</th>
                                        <th>Tanggal</th>
                                        <th>Durasi</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="rentalsTableBody">
                                    <!-- Data will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Income Report Tab -->
            <div id="income-tab" class="tab-content <?= ($data['active_tab'] == 'income') ? 'active' : ''; ?>">
                <h2>Laporan Income Bulanan</h2>

                <div class="income-filter">
                    <div class="form-group inline">
                        <label for="incomeYear">Tahun:</label>
                        <select id="incomeYear"></select>
                    </div>
                    <div class="form-group inline">
                        <label for="incomeMonth">Bulan:</label>
                        <select id="incomeMonth">
                            <option value="0">Januari</option>
                            <option value="1">Februari</option>
                            <option value="2">Maret</option>
                            <option value="3">April</option>
                            <option value="4">Mei</option>
                            <option value="5">Juni</option>
                            <option value="6">Juli</option>
                            <option value="7">Agustus</option>
                            <option value="8">September</option>
                            <option value="9">Oktober</option>
                            <option value="10">November</option>
                            <option value="11">Desember</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" id="generateReportBtn">Generate Laporan</button>
                </div>

                <div class="card" style="margin-bottom: 2rem;">
                    <div class="card-header">
                        <h3>Tren Pendapatan Harian</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="incomeChart" height="100"></canvas>
                    </div>
                </div>

                <div class="card income-summary">
                    <div class="card-body">
                        <h3>Total Income</h3>
                        <div class="income-amount" id="totalIncome">Rp 0</div>
                        <p class="income-period" id="incomePeriod">Bulan: -</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>Detail Transaksi</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Bukti</th>
                                        <th>Tanggal</th>
                                        <th>Jet Ski</th>
                                        <th>Pelanggan</th>
                                        <th>Durasi</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="incomeTableBody">
                                    <!-- Data will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery Management Tab -->
            <div id="gallery-tab" class="tab-content <?= ($data['active_tab'] == 'gallery') ? 'active' : ''; ?>">
                <div class="tab-header">
                    <h2>Kelola Galeri</h2>
                    <button class="btn btn-primary" onclick="openGalleryModal()">
                        <span>➕</span> Tambah Foto
                    </button>
                </div>

                <div class="gallery-admin-grid" id="galleryAdminGrid">
                    <!-- Gallery items will be loaded here -->
                </div>
            </div>
        </main>

    <!-- Modals -->
    <!-- Modal for Jet Ski Form -->
    <div id="jetSkiModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
            <h2 id="jetSkiModalTitle">Tambah Paket Rental Baru</h2>
            <button class="modal-close" onclick="closeModal('jetSkiModal')">&times;</button>
            </div>
            <form id="jetSkiForm" enctype="multipart/form-data">
            <input type="hidden" id="jetSkiId" name="id">
            <input type="hidden" id="existing_jetski_image" name="existing_image">
            <div class="form-row">
                <div class="form-group">
                    <label for="jetSkiName">Nama Paket *</label>
                    <input type="text" id="jetSkiName" name="name" placeholder="Contoh: Paket Keliling Mahakam" required>
                </div>
                <div class="form-group">
                    <label for="jetSkiRiderType">Tipe Rider *</label>
                    <select id="jetSkiRiderType" name="rider_type" required>
                        <option value="single">Single Rider</option>
                        <option value="couple">Couple Rider</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="jetSkiRoute">Rute Perjalanan *</label>
                <input type="text" id="jetSkiRoute" name="route" placeholder="Contoh: Jembatan Mahakam - Samarinda Seberang" required>
            </div>

            <div class="form-row" style="display: none;">
                <div class="form-group">
                    <label for="jetSkiBrand">Brand</label>
                    <input type="text" id="jetSkiBrand" name="brand" value="JetSki">
                </div>
                <div class="form-group">
                    <label for="jetSkiModel">Model</label>
                    <input type="text" id="jetSkiModel" name="model" value="Mahakam">
                </div>
                <div class="form-group">
                    <label for="jetSkiYear">Tahun</label>
                    <input type="number" id="jetSkiYear" name="year" value="2024">
                </div>
            </div>

            <div class="form-group">
                <label for="jetSkiPrice">Harga per Sesi (Rp) *</label>
                <input type="number" id="jetSkiPrice" name="price_per_hour" min="0" step="1000" required>
            </div>

            <div class="form-group">
                <label for="jetSkiImage">Foto Paket Rental *</label>
                <input type="file" id="jetSkiImage" name="image_file" accept="image/*">
                <div id="jetSkiImagePreview" style="margin-top: 10px;"></div>
            </div>

            <div class="form-group">
                <label for="jetSkiDescription">Deskripsi *</label>
                <textarea id="jetSkiDescription" name="description" rows="3" placeholder="Deskripsi singkat..." required></textarea>
            </div>
                <div class="form-group checkbox-group">
                    <label>
                        <input type="checkbox" id="jetSkiAvailable" name="is_available" checked value="1">
                        Tersedia untuk disewa
                    </label>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('jetSkiModal')">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Rental Form -->
    <div id="rentalModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="rentalModalTitle">Tambah Transaksi Sewa</h2>
                <button class="modal-close" onclick="closeModal('rentalModal')">&times;</button>
            </div>
            <form id="rentalForm" enctype="multipart/form-data">
                <input type="hidden" id="rentalId" name="id">
                <input type="hidden" id="existing_payment_proof" name="existing_payment_proof">
                
                <div class="form-group">
                    <label for="rentalJetSki">Pilih Jet Ski *</label>
                    <select id="rentalJetSki" name="jetski_id" required>
                        <option value="">-- Pilih Jet Ski --</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="rentalCustomerName">Nama Pelanggan *</label>
                        <input type="text" id="rentalCustomerName" name="customer_name" required>
                    </div>
                    <div class="form-group">
                        <label for="rentalCustomerPhone">No. Telepon (Maks 13 Angka) *</label>
                        <input type="text" id="rentalCustomerPhone" name="customer_phone" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="rentalDate">Tanggal Sewa *</label>
                        <input type="date" id="rentalDate" name="rental_date" required>
                    </div>
                    <div class="form-group">
                        <label for="rentalDuration">Durasi (jam) *</label>
                        <input type="number" id="rentalDuration" name="duration" min="1" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="payment_proof">Bukti Pembayaran</label>
                    <input type="file" id="payment_proof" name="payment_proof" accept="image/*">
                    <div id="paymentProofPreview" style="margin-top: 10px;"></div>
                </div>

                <div class="form-group">
                    <label for="rentalStatus">Status *</label>
                    <select id="rentalStatus" name="status" required>
                        <option value="active">Aktif</option>
                        <option value="completed">Selesai</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>

                <input type="hidden" id="rentalTotalPriceHidden" name="total_price">
                <div class="price-preview">
                    <p>Total Harga: <span id="rentalTotalPriceDisplay">Rp 0</span></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('rentalModal')">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Gallery Form -->
    <div id="galleryModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="galleryModalTitle">Tambah Foto Galeri</h2>
                <button class="modal-close" onclick="closeModal('galleryModal')">&times;</button>
            </div>
            <form id="galleryForm" enctype="multipart/form-data">
                <input type="hidden" id="galleryId" name="id">
                <input type="hidden" id="existing_gallery_image" name="existing_image">
                <div class="form-group">
                    <label for="galleryImage">Pilih Foto *</label>
                    <input type="file" id="galleryImage" name="gallery_file" accept="image/*">
                    <div id="galleryImagePreview" style="margin-top: 10px;"></div>
                </div>
                <div class="form-group">
                    <label for="galleryCaption">Caption *</label>
                    <input type="text" id="galleryCaption" name="caption" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('galleryModal')">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Viewer Modal -->
    <div id="imageViewerModal" class="modal">
        <div class="modal-content" style="max-width: 600px; text-align: center;">
            <div class="modal-header">
                <h2>Pratinjau Gambar</h2>
                <button class="modal-close" onclick="closeModal('imageViewerModal')">&times;</button>
            </div>
            <img id="viewerImage" src="" style="max-width: 100%; border-radius: 8px; margin-top: 15px;">
        </div>
    </div>
