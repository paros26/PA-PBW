<!-- Main Content Area -->
<div class="p-4 p-lg-5">
    
    <!-- DASHBOARD STATS -->
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-water"></i></div>
                <div>
                    <h6 class="text-muted mb-1 small uppercase">Paket Aktif</h6>
                    <h3 class="mb-0 fw-bold">{{ jetskis.length }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(13, 202, 240, 0.1); color: #0dcaf0;"><i class="bi bi-receipt"></i></div>
                <div>
                    <h6 class="text-muted mb-1 small uppercase">Total Sewa</h6>
                    <h3 class="mb-0 fw-bold">{{ rentals.length }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(25, 135, 84, 0.1); color: #198754;"><i class="bi bi-currency-dollar"></i></div>
                <div>
                    <h6 class="text-muted mb-1 small uppercase">Income Bulan Ini</h6>
                    <h3 class="mb-0 fw-bold text-success">{{ formatCurrency(totalIncome) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;"><i class="bi bi-images"></i></div>
                <div>
                    <h6 class="text-muted mb-1 small uppercase">Foto Galeri</h6>
                    <h3 class="mb-0 fw-bold text-white">{{ gallery.length }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Jet Ski Tab -->
    <div id="jetski-tab" class="tab-content <?= ($data['active_tab'] == 'jetski') ? 'active' : ''; ?>">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3 fw-bold mb-1 text-white">Manajemen Paket</h2>
                <p class="text-white small">Kelola harga, rute, dan ketersediaan armada jetski.</p>
            </div>
            <button class="btn btn-primary px-4 py-2 rounded-pill shadow-sm fw-bold" @click="openJetSkiModal()">
                <i class="bi bi-plus-lg me-2"></i> Tambah Paket
            </button>
        </div>

        <div class="card border-0">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Armada</th>
                            <th>Detail Paket</th>
                            <th>Harga/Sesi</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="jetSki in jetskis" :key="jetSki.id">
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img :src="BASEURL + '/img/jetski/' + jetSki.image_url" class="rounded-3 shadow-sm" style="width: 70px; height: 50px; object-fit: cover; border: 1px solid var(--border);" onerror="this.src='https://via.placeholder.com/70x50?text=No+Img'">
                                    <div>
                                        <p class="mb-0 fw-bold text-white">{{ jetSki.name }}</p>
                                        <span class="badge bg-dark border border-secondary text-muted small" style="font-size: 0.65rem;">ID: #{{ jetSki.id }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="small">
                                    <div class="text-white mb-1"><i class="bi bi-geo-alt me-1 text-primary"></i> {{ jetSki.route }}</div>
                                    <span class="text-primary fw-medium">{{ jetSki.rider_type === 'single' ? 'Single Rider' : 'Couple Rider' }}</span>
                                </div>
                            </td>
                            <td><span class="h6 mb-0 fw-bold text-success">{{ formatCurrency(jetSki.price_per_hour) }}</span></td>
                            <td>
                                <div v-if="jetSki.is_available == 1" class="d-flex align-items-center gap-2 text-success small fw-bold">
                                    <span class="pulse-dot bg-success"></span> Tersedia
                                </div>
                                <div v-else class="d-flex align-items-center gap-2 text-muted small fw-bold">
                                    <span class="pulse-dot bg-secondary"></span> Penuh
                                </div>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-dark btn-sm border-secondary me-2 hover-orange" @click="editJetSki(jetSki)"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-dark btn-sm border-danger text-danger" @click="deleteJetSki(jetSki.id)"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Rentals Tab -->
    <div id="rentals-tab" class="tab-content <?= ($data['active_tab'] == 'rentals') ? 'active' : ''; ?>">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h2 class="h3 fw-bold mb-1 text-white">Transaksi Terbaru</h2>
                <p class="text-muted small">Monitor penyewaan dan validasi bukti pembayaran.</p>
            </div>
            <div class="d-flex gap-2">
                <div class="search-group position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-primary"></i>
                    <input type="text" class="form-control ps-5 rounded-pill border-secondary bg-dark text-white" v-model="rentalSearchToken" placeholder="Cari token atau nama..." style="width: 250px;">
                </div>
                <div class="sort-group">
                    <select class="form-select rounded-pill border-secondary bg-dark text-white px-4" v-model="rentalSortOrder" style="width: 180px;">
                        <option value="newest">📅 Terbaru</option>
                        <option value="oldest">📅 Terlama</option>
                        <option value="name_asc">👤 Nama (A-Z)</option>
                        <option value="name_desc">👤 Nama (Z-A)</option>
                        <option value="price_high">💰 Harga Tertinggi</option>
                        <option value="price_low">💰 Harga Terendah</option>
                    </select>
                </div>
                <button class="btn btn-primary px-3 rounded-pill" @click="openRentalModal()">
                    <i class="bi bi-plus-lg me-1"></i> Transaksi Baru
                </button>
            </div>
        </div>

        <div class="card border-0">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Paket Armada</th>
                            <th>Tanggal</th>
                            <th class="text-center">Sesi</th>
                            <th>Total Bayar</th>
                            <th class="text-center">Bukti</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="rental in filteredRentals" :key="rental.id" :class="{'opacity-50': rental.status === 'deleted'}">
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="token-box text-center p-2 rounded bg-dark border border-secondary" style="min-width: 60px;">
                                        <div class="x-small text-muted mb-0" style="font-size: 0.6rem;">TOKEN</div>
                                        <div class="fw-bold text-primary small">{{ rental.token }}</div>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-bold text-white">{{ rental.customer_name }}</p>
                                        <small class="text-white small"><i class="bi bi-whatsapp me-1"></i>{{ rental.customer_phone }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="small fw-medium text-white">{{ rental.jetski_name }}</span></td>
                            <td><span class="small fw-bold text-white">{{ formatDate(rental.rental_date) }}</span></td>
                            <td class="text-center"><span class="fw-bold text-white fs-5">{{ rental.sesi }}</span></td>
                            <td><span class="fw-bold text-primary">{{ formatCurrency(rental.total_price) }}</span></td>
                            <td class="text-center">
                                <div v-if="rental.payment_proof" class="position-relative d-inline-block">
                                    <img :src="BASEURL + '/img/payments/' + rental.payment_proof" 
                                         class="rounded shadow-sm cursor-pointer hover-scale" 
                                         style="width: 50px; height: 50px; object-fit: cover; border: 1px solid var(--border);"
                                         @click="viewPaymentProof(rental.payment_proof)">
                                </div>
                                <div v-else class="text-muted x-small">
                                    <i class="bi bi-slash-circle me-1"></i> Kosong
                                </div>
                            </td>
                            <td>
                                <div v-if="rental.status === 'active'" class="d-flex align-items-center gap-2 text-primary small fw-bold">
                                    <span class="status-dot pulse-blue"></span> Aktif
                                </div>
                                <div v-else-if="rental.status === 'completed'" class="d-flex align-items-center gap-2 text-success small fw-bold">
                                    <i class="bi bi-check-circle-fill"></i> Selesai
                                </div>
                                <div v-else-if="rental.status === 'cancelled'" class="d-flex align-items-center gap-2 text-danger small fw-bold">
                                    <i class="bi bi-x-circle-fill"></i> Dibatalkan
                                </div>
                                <div v-else class="d-flex align-items-center gap-2 text-muted small fw-bold">
                                    <i class="bi bi-trash-fill"></i> Dihapus
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button v-if="rental.payment_proof" class="btn btn-dark btn-sm border-info text-info" @click="viewPaymentProof(rental.payment_proof)"><i class="bi bi-image"></i></button>
                                    <button class="btn btn-dark btn-sm border-secondary hover-orange" @click="editRental(rental)"><i class="bi bi-pencil-square"></i></button>
                                    <button class="btn btn-dark btn-sm border-danger text-danger" @click="deleteRental(rental.id)"><i class="bi bi-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Income Report Tab -->
    <div id="income-tab" class="tab-content <?= ($data['active_tab'] == 'income') ? 'active' : ''; ?>">
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card h-100 border-0">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <h5 class="mb-0 fw-bold text-white">Grafik Pendapatan</h5>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm bg-dark text-white border-secondary" v-model="reportMonth" style="width: 130px;">
                                <option v-for="(m, i) in ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']" :key="i" :value="i">{{ m }}</option>
                            </select>
                            <select id="incomeYear" class="form-select form-select-sm bg-dark text-white border-secondary" v-model="reportYear" style="width: 100px;"></select>
                            <button class="btn btn-primary btn-sm rounded-pill px-3" @click="generateIncomeReport"><i class="bi bi-arrow-clockwise"></i></button>
                        </div>
                    </div>
                    <div class="card-body"><canvas id="incomeChart" style="max-height: 300px;"></canvas></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-primary text-white h-100 border-0 shadow-lg" style="background: var(--primary-gradient) !important;">
                    <div class="card-body p-4 d-flex flex-column justify-content-center text-center">
                        <div class="mb-3"><div class="mx-auto bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;"><i class="bi bi-wallet2 fs-2 text-white"></i></div></div>
                        <h6 class="text-uppercase opacity-75 small fw-bold mb-1">Total Income</h6>
                        <h2 class="fw-bold mb-3 text-warning">{{ formatCurrency(totalIncome) }}</h2>
                        <div class="badge bg-black bg-opacity-25 rounded-pill py-2 px-3 small">{{ reportMonthName }} {{ reportYear }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Tab -->
    <div id="gallery-tab" class="tab-content <?= ($data['active_tab'] == 'gallery') ? 'active' : ''; ?>">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h2 class="h3 fw-bold mb-1 text-white">Galeri Dokumentasi</h2>
                <p class="text-muted small">Kelola foto-foto kegiatan dan testimoni di Pantai Mahakam.</p>
            </div>
            <div class="d-flex gap-2">
                <div class="search-group position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-primary"></i>
                    <input type="text" class="form-control ps-5 rounded-pill border-secondary bg-dark text-white" v-model="gallerySearchToken" placeholder="Cari caption..." style="width: 200px;">
                </div>
                <button class="btn btn-primary rounded-pill px-4" @click="openGalleryModal()">
                    <i class="bi bi-upload me-2"></i> Unggah Foto Baru
                </button>
            </div>
        </div>
        
        <div class="row g-4">
            <div v-for="item in filteredGallery" :key="item.id" class="col-md-4 col-xl-3">
                <div class="card h-100 border-0 shadow-sm overflow-hidden bg-dark">
                    <img :src="BASEURL + '/img/gallery/' + item.image_url" class="card-img-top" 
                         style="height: 200px; object-fit: cover; border-bottom: 1px solid var(--border);"
                         onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                    <div class="card-body p-3">
                        <p class="card-text text-white small fw-bold mb-3" style="min-height: 40px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ item.caption }}
                        </p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-warning btn-sm flex-fill border-secondary" @click="editGallery(item)">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </button>
                            <button class="btn btn-outline-danger btn-sm flex-fill border-secondary text-danger" @click="deleteGalleryImage(item.id)">
                                <i class="bi bi-trash me-1"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="gallery.length === 0" class="col-12 text-center py-5">
                <i class="bi bi-images display-1 text-muted opacity-25"></i>
                <p class="text-muted mt-3">Belum ada foto dalam galeri.</p>
            </div>
        </div>
    </div>
</div>

<!-- MODALS -->

<!-- Jet Ski Modal -->
<div class="modal fade" id="jetSkiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md-custom modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content overflow-hidden">
            <div class="modal-header-premium py-4 px-4">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary-gradient p-2 rounded-3 shadow-lg">
                            <i class="bi bi-water text-white fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-white mb-0" style="letter-spacing: -0.5px;">{{ formJetSki.modalTitle }}</h5>
                            <p class="text-muted x-small mb-0 opacity-75">Detail konfigurasi paket armada Mahakam</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
            </div>

            <form id="jetSkiForm">
                <div class="modal-body p-4 pt-2">
                    <input type="hidden" name="id" :value="formJetSki.id">
                    <input type="hidden" name="existing_image" :value="formJetSki.existing_image">
                    
                    <!-- Hidden default values to satisfy database requirement -->
                    <input type="hidden" name="brand" value="Yamaha">
                    <input type="hidden" name="model" value="Mahakam Series">
                    <input type="hidden" name="year" :value="new Date().getFullYear()">
                    
                    <div class="row g-4">
                        <!-- Nama Paket -->
                        <div class="col-12">
                            <div class="floating-field">
                                <label>Identitas Paket</label>
                                <div class="field-container">
                                    <i class="bi bi-tag field-icon"></i>
                                    <input type="text" name="name" v-model="formJetSki.name" placeholder="Masukkan nama armada/paket..." minlength="3" required>
                                </div>
                            </div>
                        </div>

                        <!-- Tipe & Harga (Balanced Row) -->
                        <div class="col-md-6">
                            <div class="floating-field">
                                <label>Kategori Rider</label>
                                <div class="field-container">
                                    <i class="bi bi-person-badge field-icon"></i>
                                    <select name="rider_type" v-model="formJetSki.rider_type" required>
                                        <option value="single">Single Rider</option>
                                        <option value="couple">Couple Rider</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="floating-field">
                                <label>Investasi (IDR)</label>
                                <div class="field-container">
                                    <span class="text-primary fw-bold small">Rp</span>
                                    <input type="number" name="price_per_hour" v-model="formJetSki.price_per_hour" placeholder="0" min="1000" required>
                                </div>
                            </div>
                        </div>

                        <!-- Rute -->
                        <div class="col-12">
                            <div class="floating-field">
                                <label>Rute Perjalanan</label>
                                <div class="field-container">
                                    <i class="bi bi-signpost-2 field-icon"></i>
                                    <input type="text" name="route" v-model="formJetSki.route" placeholder="Contoh: Dermaga - Jembatan Mahakam IV" required>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Foto -->
                        <div class="col-12">
                            <div class="floating-field">
                                <label>Visual Paket</label>
                                <div class="field-container">
                                    <i class="bi bi-image field-icon"></i>
                                    <input type="file" name="image_file" class="custom-file-upload" accept="image/*">
                                </div>
                                <div class="mt-2 d-flex align-items-center gap-2" v-if="formJetSki.existing_image">
                                    <span class="badge bg-white bg-opacity-5 text-muted border border-white border-opacity-10 py-2 px-3 fw-normal">
                                        <i class="bi bi-paperclip me-1"></i> {{ formJetSki.existing_image }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Status Toggle Card -->
                        <div class="col-12">
                            <div class="publication-card d-flex justify-content-between align-items-center shadow-sm">
                                <div class="d-flex align-items-center gap-3">
                                    <div :class="formJetSki.is_available ? 'bg-success' : 'bg-secondary'" class="rounded-circle shadow-lg" style="width: 10px; height: 10px;"></div>
                                    <div>
                                        <h6 class="text-white fw-bold mb-0 small">Publikasi Paket</h6>
                                        <p class="text-muted x-small mb-0">Aktifkan untuk tampil di website</p>
                                    </div>
                                </div>
                                <div class="status-pill-switch scale-90">
                                    <div class="status-pill-item py-1 px-4" :class="!formJetSki.is_available ? 'active full' : ''" @click="formJetSki.is_available = false">NONAKTIF</div>
                                    <div class="status-pill-item py-1 px-4" :class="formJetSki.is_available ? 'active available' : ''" @click="formJetSki.is_available = true">AKTIF</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4 pt-0 bg-transparent gap-2">
                    <button type="button" class="btn btn-link text-muted x-small fw-bold text-decoration-none px-4" data-bs-dismiss="modal">BATALKAN</button>
                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill shadow-lg fw-bold tracking-widest flex-grow-1 flex-md-grow-0">
                        SIMPAN DATA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Rental Modal -->
<div class="modal fade" id="rentalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md-custom modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content overflow-hidden">
            <div class="modal-header-premium py-4 px-4">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary-gradient p-2 rounded-3 shadow-lg">
                            <i class="bi bi-receipt text-white fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-white mb-0" style="letter-spacing: -0.5px;">{{ formRental.modalTitle }}</h5>
                            <p class="text-muted x-small mb-0 opacity-75">Dokumentasi transaksi penyewaan armada</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
            </div>

            <form id="rentalForm">
                <div class="modal-body p-4 pt-2">
                    <input type="hidden" name="id" :value="formRental.id">
                    <input type="hidden" name="existing_payment_proof" :value="formRental.existing_payment_proof">
                    
                    <div class="row g-4">
                        <!-- Paket Armada -->
                        <div class="col-12">
                            <div class="floating-field">
                                <label>Pilihan Armada</label>
                                <div class="field-container">
                                    <i class="bi bi-water field-icon"></i>
                                    <select name="jetski_id" v-model="formRental.jetski_id" required>
                                        <option value="">-- Pilih Paket Armada --</option>
                                        <option v-for="js in jetskis" :key="js.id" :value="js.id">
                                            {{ js.name }} ({{ formatCurrency(js.price_per_hour) }})
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Nama Pelanggan -->
                        <div class="col-12">
                            <div class="floating-field">
                                <label>Identitas Pelanggan</label>
                                <div class="field-container">
                                    <i class="bi bi-person field-icon"></i>
                                    <input type="text" name="customer_name" v-model="formRental.customer_name" placeholder="Nama lengkap pelanggan..." minlength="3" required>
                                </div>
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <div class="col-12">
                            <div class="floating-field">
                                <label>Kontak WhatsApp</label>
                                <div class="field-container">
                                    <i class="bi bi-whatsapp field-icon"></i>
                                    <input type="text" name="customer_phone" v-model="formRental.customer_phone" placeholder="08xxxxxxxxxx" pattern="[0-9]{10,13}" title="Nomor WhatsApp harus 10-13 digit angka" required>
                                </div>
                            </div>
                        </div>

                        <!-- Tanggal & Sesi -->
                        <div class="col-md-6">
                            <div class="floating-field">
                                <label>Tanggal Sewa</label>
                                <div class="field-container">
                                    <i class="bi bi-calendar-event field-icon"></i>
                                    <input type="date" name="rental_date" v-model="formRental.rental_date" :min="new Date().toISOString().split('T')[0]" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="floating-field">
                                <label>Durasi (Sesi)</label>
                                <div class="field-container">
                                    <i class="bi bi-clock-history field-icon"></i>
                                    <input type="number" name="sesi" v-model="formRental.sesi" min="1" max="5" placeholder="1" required>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Bukti -->
                        <div class="col-12">
                            <div class="floating-field">
                                <label>Status & Bukti Pembayaran</label>
                                <div class="field-container mb-2">
                                    <i class="bi bi-shield-check field-icon"></i>
                                    <select name="status" v-model="formRental.status">
                                        <option value="active">🔵 Aktif (Proses)</option>
                                        <option value="completed">🟢 Selesai (Lunas)</option>
                                        <option value="cancelled">🔴 Dibatalkan</option>
                                    </select>
                                </div>
                                <div class="field-container border-top border-white border-opacity-5 pt-2 mt-1">
                                    <i class="bi bi-cloud-arrow-up field-icon"></i>
                                    <input type="file" name="payment_proof" class="custom-file-upload" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <!-- Total Price Display (Premium Box) -->
                        <div class="col-12">
                            <div class="publication-card text-center border-primary border-opacity-20" style="background: linear-gradient(145deg, rgba(255, 140, 0, 0.05), rgba(0,0,0,0.4));">
                                <span class="text-muted x-small fw-bold text-uppercase tracking-widest d-block mb-1">Estimasi Total Tagihan</span>
                                <h3 class="text-primary fw-bold mb-0">{{ formatCurrency(formRental.total_price) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4 pt-2 bg-transparent">
                    <button type="button" class="btn btn-link text-muted x-small fw-bold text-decoration-none me-auto" data-bs-dismiss="modal">BATALKAN</button>
                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill shadow-lg fw-bold tracking-wider">
                        KONFIRMASI TRANSAKSI
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Gallery Modal -->
<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <div class="modal-header border-0 px-4 pt-4">
                <h4 class="modal-title fw-bold text-white">{{ formGallery.modalTitle }}</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="galleryForm">
                <div class="modal-body px-4 pb-4 text-white">
                    <input type="hidden" name="id" :value="formGallery.id">
                    <input type="hidden" name="existing_image" :value="formGallery.existing_image">

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">Foto Galeri</label>
                        <div class="p-3 bg-dark rounded-4 border border-secondary text-center mb-2">
                            <input type="file" name="gallery_file" class="form-control bg-transparent border-0 text-white" accept="image/*" @change="previewImage($event, 'galleryImagePreview')">
                        </div>
                        <div id="galleryImagePreview"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">Judul / Caption</label>
                        <input type="text" name="caption" v-model="formGallery.caption" class="form-control rounded-4 py-3 bg-dark border-secondary text-white" placeholder="Contoh: Keseruan sore hari di dermaga" required>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-4 shadow fw-bold">
                        <i class="bi bi-cloud-upload me-2"></i> SIMPAN KE GALERI
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Kustom -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 30px; background: rgba(15, 15, 15, 0.95) !important;">
            <div class="modal-body p-4 text-center">
                <div class="mx-auto mb-3 bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-exclamation-triangle fs-2 text-danger"></i>
                </div>
                <h5 class="fw-bold text-white mb-2" id="confirmTitle">Hapus Data?</h5>
                <p class="text-muted small mb-4" id="confirmMessage">Tindakan ini tidak dapat dibatalkan.</p>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-dark flex-fill rounded-pill border-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger flex-fill rounded-pill shadow-sm fw-bold" id="confirmActionBtn">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Viewer Modal (Cinematic Style) -->
<div class="modal fade" id="imageViewerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-body p-0 text-center position-relative">
                <div class="position-absolute top-0 end-0 m-3 d-flex gap-2" style="z-index: 10;">
                    <button type="button" class="btn btn-blur rounded-circle p-2 text-white" data-bs-dismiss="modal" style="width: 45px; height: 45px;">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <img id="viewerImage" src="" class="img-fluid rounded-4 shadow-lg border border-white border-opacity-10" style="max-height: 85vh;">
            </div>
        </div>
    </div>
</div>

<style>
    .pulse-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; box-shadow: 0 0 0 rgba(25, 135, 84, 0.4); animation: pulse-green 2s infinite; }
    .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
    .pulse-blue { background-color: #0d6efd; box-shadow: 0 0 0 rgba(13, 110, 253, 0.4); animation: pulse-blue 2s infinite; }
    @keyframes pulse-green { 0% { box-shadow: 0 0 0 0px rgba(25, 135, 84, 0.7); } 70% { box-shadow: 0 0 0 10px rgba(25, 135, 84, 0); } 100% { box-shadow: 0 0 0 0px rgba(25, 135, 84, 0); } }
    @keyframes pulse-blue { 0% { box-shadow: 0 0 0 0px rgba(13, 110, 253, 0.7); } 70% { box-shadow: 0 0 0 10px rgba(13, 110, 253, 0); } 100% { box-shadow: 0 0 0 0px rgba(13, 110, 253, 0); } }
    .hover-orange:hover { border-color: var(--primary) !important; color: var(--primary) !important; }
    .bg-gradient-dark { background: linear-gradient(to top, rgba(0,0,0,0.9), transparent); }
    .btn-blur { background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); }
    .group:hover .group-hover-visible { opacity: 1 !important; transform: translateY(0); }
    .transition-all { transition: all 0.3s ease; }
    .x-small { font-size: 0.7rem; }
</style>
