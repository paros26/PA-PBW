document.addEventListener('DOMContentLoaded', function() {
    initAdmin();
});

function initAdmin() {
    // Initialize tabs
    initTabs();
    
    // Load initial data
    loadJetSkis();
    loadRentals();
    initIncomeReport();
    loadGalleryAdmin();
    
    // Jet Ski Management
    document.getElementById('jetSkiForm').addEventListener('submit', handleJetSkiSubmit);
    
    // Rental Management
    document.getElementById('rentalForm').addEventListener('submit', handleRentalSubmit);
    document.getElementById('rentalSearchToken').addEventListener('input', applyRentalFiltersAndSort);
    document.getElementById('rentalSort').addEventListener('change', applyRentalFiltersAndSort);
    document.getElementById('btnSearchToken').addEventListener('click', applyRentalFiltersAndSort);
    
    // Income Report
    document.getElementById('generateReportBtn').addEventListener('click', generateIncomeReport);
    
    // Gallery Management
    document.getElementById('galleryForm').addEventListener('submit', handleGallerySubmit);
    
    // Rental form: Calculate price on change
    document.getElementById('rentalJetSki').addEventListener('change', calculateRentalPrice);
    document.getElementById('rentalDuration').addEventListener('input', calculateRentalPrice);
}

// Tabs
function initTabs() {
    const tabButtons = document.querySelectorAll('.admin-nav-btn');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.dataset.tab;
            
            // Remove active class from all buttons and tabs
            tabButtons.forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            
            // Add active class to clicked button and corresponding tab
            this.classList.add('active');
            document.getElementById(`${tabName}-tab`).classList.add('active');
        });
    });
}

// ========== JET SKI MANAGEMENT ==========

// Global state for data
let currentJetSkis = [];
let currentRentals = [];

async function loadJetSkis() {
    try {
        const response = await fetch(`${BASEURL}/api/jetskis`);
        currentJetSkis = await response.json();
        const tbody = document.getElementById('jetSkiTableBody');
        
        if (currentJetSkis.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 2rem; color: #666;">Belum ada data paket rental</td></tr>';
            return;
        }
        
        tbody.innerHTML = currentJetSkis.map((jetSki, index) => `
            <tr>
                <td>
                    <img src="${BASEURL}/img/jetski/${jetSki.image_url}" alt="${jetSki.name}" class="table-image"
                         onerror="this.src='https://via.placeholder.com/64?text=No+Image'">
                </td>
                <td><strong>${jetSki.name}</strong></td>
                <td>
                    <span class="rider-badge" style="font-size: 0.7rem; padding: 0.2rem 0.5rem;">
                        ${jetSki.rider_type === 'single' ? '👤 Single' : '👥 Couple'}
                    </span>
                </td>
                <td><small>${jetSki.route || '-'}</small></td>
                <td>${formatCurrency(jetSki.price_per_hour)}</td>
                <td>
                    <span class="status-badge ${jetSki.is_available == 1 ? 'status-available' : 'status-unavailable'}">
                        ${jetSki.is_available == 1 ? 'Tersedia' : 'Penuh'}
                    </span>
                </td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-icon edit" onclick="prepareEditJetSki(${index})">✏️</button>
                        <button class="btn-icon delete" onclick="deleteJetSki('${jetSki.id}')">🗑️</button>
                    </div>
                </td>
            </tr>
        `).join('');
        
        updateRentalJetSkiOptions(currentJetSkis);
    } catch (error) {
        console.error('Error loading jetskis:', error);
    }
}

function prepareEditJetSki(index) {
    const jetSki = currentJetSkis[index];
    if (jetSki) {
        editJetSki(jetSki);
    }
}

function openJetSkiModal() {
    const form = document.getElementById('jetSkiForm');
    form.reset();
    document.getElementById('jetSkiId').value = '';
    document.getElementById('existing_jetski_image').value = '';
    document.getElementById('jetSkiModalTitle').textContent = 'Tambah Paket Rental Baru';
    document.getElementById('jetSkiAvailable').checked = true;
    document.getElementById('jetSkiImagePreview').innerHTML = '';
    openModal('jetSkiModal');
}

function editJetSki(jetSki) {
    document.getElementById('jetSkiId').value = jetSki.id;
    document.getElementById('existing_jetski_image').value = jetSki.image_url;
    document.getElementById('jetSkiModalTitle').textContent = 'Ubah Paket Rental';
    document.getElementById('jetSkiName').value = jetSki.name;
    document.getElementById('jetSkiRiderType').value = jetSki.rider_type || 'single';
    document.getElementById('jetSkiRoute').value = jetSki.route || '';
    document.getElementById('jetSkiPrice').value = jetSki.price_per_hour;
    document.getElementById('jetSkiDescription').value = jetSki.description;
    document.getElementById('jetSkiAvailable').checked = jetSki.is_available == 1;
    
    // Ensure hidden technical fields are preserved during update
    document.getElementById('jetSkiBrand').value = jetSki.brand || 'JetSki';
    document.getElementById('jetSkiModel').value = jetSki.model || 'Mahakam';
    document.getElementById('jetSkiYear').value = jetSki.year || 2024;
    
    if (jetSki.image_url) {
        document.getElementById('jetSkiImagePreview').innerHTML = `
            <img src="${BASEURL}/img/jetski/${jetSki.image_url}" style="height: 50px; border-radius: 4px;">
            <p style="font-size: 0.7rem;">Foto saat ini</p>
        `;
    } else {
        document.getElementById('jetSkiImagePreview').innerHTML = '';
    }
    
    openModal('jetSkiModal');
}

async function handleJetSkiSubmit(e) {
    e.preventDefault();
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    
    try {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>⏳</span> Menyimpan...';

        const id = document.getElementById('jetSkiId').value;
        const url = id ? `${BASEURL}/api/updateJetski` : `${BASEURL}/api/addJetski`;
        
        const formData = new FormData(this);
        // Explicitly set is_available value (1 if checked, 0 if not)
        const isAvailable = document.getElementById('jetSkiAvailable').checked ? '1' : '0';
        formData.set('is_available', isAvailable);

        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
        
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        
        const result = await response.json();
        
        if (result.status === 'success') {
            showToast('Paket rental berhasil disimpan!', 'success');
            loadJetSkis();
            closeModal('jetSkiModal');
        } else {
            showToast(result.message || 'Gagal menyimpan paket rental', 'error');
        }
    } catch (error) {
        console.error('Submit error:', error);
        showToast('Terjadi kesalahan koneksi atau sistem', 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    }
}

async function deleteJetSki(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus paket rental ini?')) return;
    
    const response = await fetch(`${BASEURL}/api/deleteJetski/${id}`);
    const result = await response.json();
    
    if (result.status === 'success') {
        showToast('Paket rental berhasil dihapus!', 'success');
        loadJetSkis();
    } else {
        showToast('Gagal menghapus paket rental', 'error');
    }
}

// ========== RENTAL MANAGEMENT ==========

async function loadRentals() {
    try {
        const response = await fetch(`${BASEURL}/api/rentals`);
        currentRentals = await response.json();
        applyRentalFiltersAndSort();
    } catch (error) {
        console.error('Error loading rentals:', error);
    }
}

function applyRentalFiltersAndSort() {
    const searchToken = document.getElementById('rentalSearchToken').value.toLowerCase();
    const sortOrder = document.getElementById('rentalSort').value;
    
    let filteredRentals = [...currentRentals];
    
    // Filter by token
    if (searchToken) {
        filteredRentals = filteredRentals.filter(rental => 
            (rental.token && rental.token.toLowerCase().includes(searchToken))
        );
    }
    
    // Sort
    filteredRentals.sort((a, b) => {
        const dateA = new Date(a.rental_date);
        const dateB = new Date(b.rental_date);
        
        if (sortOrder === 'newest') {
            return dateB - dateA;
        } else {
            return dateA - dateB;
        }
    });
    
    renderRentalsTable(filteredRentals);
}

function renderRentalsTable(rentals) {
    const tbody = document.getElementById('rentalsTableBody');
    
    if (rentals.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" style="text-align: center; padding: 2rem; color: #666;">Data tidak ditemukan</td></tr>';
        return;
    }
    
    tbody.innerHTML = rentals.map((rental) => {
        // Find index in currentRentals for editing
        const originalIndex = currentRentals.findIndex(r => r.id === rental.id);
        const isDeleted = rental.status === 'deleted';
        return `
            <tr class="${isDeleted ? 'row-deleted' : ''}">
                <td>
                    ${rental.payment_proof ? 
                        `<img src="${BASEURL}/img/payments/${rental.payment_proof}" class="table-image" style="cursor: pointer;" onclick="viewPaymentProof('${rental.payment_proof}')">` : 
                        '<span style="color: #999; font-size: 0.8rem;">No Proof</span>'}
                </td>
                <td><code style="background: #333; padding: 2px 5px; border-radius: 4px; color: var(--primary); font-weight: bold;">${rental.token || '-'}</code></td>
                <td>${rental.jetski_name}</td>
                <td>${rental.customer_name}</td>
                <td>${rental.customer_phone}</td>
                <td>${formatDate(rental.rental_date)}</td>
                <td>${rental.duration} sesi</td>
                <td><strong>${formatCurrency(rental.total_price)}</strong></td>
                <td>
                    <span class="status-badge status-${rental.status}">
                        ${rental.status === 'active' ? 'Aktif' : 
                        rental.status === 'completed' ? 'Selesai' : 
                        rental.status === 'cancelled' ? 'Dibatalkan' : 'Dihapus'}
                    </span>
                </td>
                <td>
                    <div class="action-buttons">
                        ${!isDeleted ? `
                            <button class="btn-icon edit" onclick="prepareEditRental(${originalIndex})">✏️</button>
                            <button class="btn-icon delete" onclick="deleteRental('${rental.id}')">🗑️</button>
                        ` : '<span style="color: #999; font-size: 0.8rem;">Non-editable</span>'}
                    </div>
                </td>
            </tr>
        `;
    }).join('');
}

function prepareEditRental(index) {
    const rental = currentRentals[index];
    if (rental) {
        editRental(rental);
    }
}

function viewPaymentProof(fileName) {
    document.getElementById('viewerImage').src = `${BASEURL}/img/payments/${fileName}`;
    openModal('imageViewerModal');
}

function updateRentalJetSkiOptions(jetSkis) {
    const select = document.getElementById('rentalJetSki');
    if (!select) return;
    
    select.innerHTML = '<option value="">-- Pilih Paket Rental --</option>' +
        jetSkis.map(js => `
            <option value="${js.id}" data-price="${js.price_per_hour}">${js.name} - ${formatCurrency(js.price_per_hour)}/sesi</option>
        `).join('');
}

function openRentalModal() {
    const form = document.getElementById('rentalForm');
    form.reset();
    document.getElementById('rentalId').value = '';
    document.getElementById('existing_payment_proof').value = '';
    document.getElementById('rentalModalTitle').textContent = 'Tambah Transaksi Sewa';
    document.getElementById('rentalDate').value = new Date().toISOString().split('T')[0];
    document.getElementById('rentalDuration').value = 1;
    document.getElementById('rentalStatus').value = 'active';
    document.getElementById('rentalTotalPriceDisplay').textContent = 'Rp 0';
    document.getElementById('paymentProofPreview').innerHTML = '';
    openModal('rentalModal');
}

function editRental(rental) {
    document.getElementById('rentalId').value = rental.id;
    document.getElementById('existing_payment_proof').value = rental.payment_proof || '';
    document.getElementById('rentalModalTitle').textContent = 'Ubah Transaksi';
    document.getElementById('rentalJetSki').value = rental.jetski_id;
    document.getElementById('rentalCustomerName').value = rental.customer_name;
    document.getElementById('rentalCustomerPhone').value = rental.customer_phone;
    document.getElementById('rentalDate').value = rental.rental_date;
    document.getElementById('rentalDuration').value = rental.duration;
    document.getElementById('rentalStatus').value = rental.status;
    
    if (rental.payment_proof) {
        document.getElementById('paymentProofPreview').innerHTML = `
            <img src="${BASEURL}/img/payments/${rental.payment_proof}" style="height: 50px; border-radius: 4px;">
            <p style="font-size: 0.7rem;">Bukti saat ini</p>
        `;
    } else {
        document.getElementById('paymentProofPreview').innerHTML = '';
    }
    
    calculateRentalPrice();
    openModal('rentalModal');
}

function calculateRentalPrice() {
    const jetSkiSelect = document.getElementById('rentalJetSki');
    const durationInput = document.getElementById('rentalDuration');
    const duration = parseInt(durationInput.value) || 0;
    const selectedOption = jetSkiSelect.options[jetSkiSelect.selectedIndex];
    
    // Pastikan selectedOption ada dan memiliki dataset price
    const price = (selectedOption && selectedOption.dataset.price) ? parseInt(selectedOption.dataset.price) : 0;
    
    const total = price * duration;
    document.getElementById('rentalTotalPriceDisplay').textContent = formatCurrency(total);
    document.getElementById('rentalTotalPriceHidden').value = total;
}

async function handleRentalSubmit(e) {
    e.preventDefault();
    
    const totalPrice = document.getElementById('rentalTotalPriceHidden').value;
    if (!totalPrice || totalPrice == 0) {
        showToast('Mohon pilih paket rental dan durasi yang valid', 'error');
        return;
    }
    
    const id = document.getElementById('rentalId').value;
    const url = id ? `${BASEURL}/api/updateRental` : `${BASEURL}/api/addRental`;
    
    const formData = new FormData(this);
    const response = await fetch(url, {
        method: 'POST',
        body: formData
    });
    
    const result = await response.json();
    
    if (result.status === 'success') {
        showToast('Transaksi berhasil disimpan!', 'success');
        loadRentals();
        closeModal('rentalModal');
    } else {
        showToast(result.message || 'Gagal menyimpan transaksi', 'error');
    }
}

async function deleteRental(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) return;
    
    const response = await fetch(`${BASEURL}/api/deleteRental/${id}`);
    const result = await response.json();
    
    if (result.status === 'success') {
        showToast('Transaksi berhasil dihapus!', 'success');
        loadRentals();
    } else {
        showToast('Gagal menghapus transaksi', 'error');
    }
}

// ========== INCOME REPORT ==========

function initIncomeReport() {
    const yearSelect = document.getElementById('incomeYear');
    if (!yearSelect) return;
    const currentYear = new Date().getFullYear();
    
    for (let year = currentYear; year >= currentYear - 5; year--) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    }
    
    document.getElementById('incomeMonth').value = new Date().getMonth().toString();
}

let incomeChart = null;

async function generateIncomeReport() {
    const year = parseInt(document.getElementById('incomeYear').value);
    const month = parseInt(document.getElementById('incomeMonth').value);
    
    const response = await fetch(`${BASEURL}/api/rentals`);
    const rentals = await response.json();
    
    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    
    // Filter rentals: completed and matching month/year
    const filteredRentals = rentals.filter(r => {
        const rentalDate = new Date(r.rental_date);
        return rentalDate.getFullYear() === year && 
               rentalDate.getMonth() === month &&
               r.status === 'completed';
    });
    
    // Calculate daily income for chart
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const dailyData = Array(daysInMonth).fill(0);
    const labels = Array.from({length: daysInMonth}, (_, i) => i + 1);

    filteredRentals.forEach(r => {
        const day = new Date(r.rental_date).getDate();
        dailyData[day - 1] += parseFloat(r.total_price);
    });

    updateIncomeChart(labels, dailyData, monthNames[month]);

    const totalIncome = filteredRentals.reduce((sum, r) => sum + parseFloat(r.total_price), 0);
    
    document.getElementById('totalIncome').textContent = formatCurrency(totalIncome);
    document.getElementById('incomePeriod').textContent = `Bulan: ${monthNames[month]} ${year}`;
    
    const tbody = document.getElementById('incomeTableBody');
    
    if (filteredRentals.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 2rem; color: #666;">Tidak ada transaksi selesai di bulan ini</td></tr>';
        return;
    }
    
    tbody.innerHTML = filteredRentals.map(rental => `
        <tr>
            <td>
                ${rental.payment_proof ? 
                    `<img src="${BASEURL}/img/payments/${rental.payment_proof}" class="table-image" style="cursor: pointer;" onclick="viewPaymentProof('${rental.payment_proof}')">` : 
                    '<span style="color: #999; font-size: 0.8rem;">No Proof</span>'}
            </td>
            <td>${formatDate(rental.rental_date)}</td>
            <td>${rental.jetski_name}</td>
            <td>${rental.customer_name}</td>
            <td>${rental.duration} sesi</td>
            <td><strong>${formatCurrency(rental.total_price)}</strong></td>
        </tr>
    `).join('');
}

function updateIncomeChart(labels, data, monthName) {
    const ctx = document.getElementById('incomeChart').getContext('2d');
    
    if (incomeChart) {
        incomeChart.destroy();
    }

    incomeChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: `Pendapatan Harian (${monthName})`,
                data: data,
                borderColor: '#ff8c00',
                backgroundColor: 'rgba(255, 140, 0, 0.1)',
                borderWidth: 3,
                tension: 0.3,
                fill: true,
                pointBackgroundColor: '#ff8c00',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: { color: '#eeeeee' }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#333333' },
                    ticks: { 
                        color: '#aaaaaa',
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: { color: '#333333' },
                    ticks: { color: '#aaaaaa' },
                    title: {
                        display: true,
                        text: 'Tanggal',
                        color: '#888'
                    }
                }
            }
        }
    });
}

// ========== GALLERY MANAGEMENT ==========

let currentGallery = [];

async function loadGalleryAdmin() {
    try {
        const response = await fetch(`${BASEURL}/api/gallery`);
        currentGallery = await response.json();
        const grid = document.getElementById('galleryAdminGrid');
        
        if (!grid) return;
        
        if (currentGallery.length === 0) {
            grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: #666;">Belum ada foto galeri</div>';
            return;
        }
        
        grid.innerHTML = currentGallery.map((item, index) => `
            <div class="gallery-admin-item">
                <img src="${BASEURL}/img/gallery/${item.image_url}" alt="${item.caption}" class="gallery-admin-image"
                     onerror="this.src='https://via.placeholder.com/250x180?text=No+Image'">
                <div class="gallery-admin-content">
                    <div>
                        <p class="gallery-admin-caption">${item.caption}</p>
                        <p class="gallery-admin-date">Diunggah: ${formatDate(item.upload_date)}</p>
                    </div>
                    <div class="gallery-admin-actions">
                        <button class="btn-icon edit" onclick="prepareEditGallery(${index})">✏️ Edit</button>
                        <button class="btn-icon delete" onclick="deleteGalleryImage('${item.id}')">🗑️ Hapus</button>
                    </div>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading gallery:', error);
    }
}

function prepareEditGallery(index) {
    const item = currentGallery[index];
    if (item) {
        editGallery(item);
    }
}

function openGalleryModal() {
    const form = document.getElementById('galleryForm');
    form.reset();
    document.getElementById('galleryId').value = '';
    document.getElementById('existing_gallery_image').value = '';
    document.getElementById('galleryModalTitle').textContent = 'Tambah Foto Galeri';
    document.getElementById('galleryImagePreview').innerHTML = '';
    openModal('galleryModal');
}

function editGallery(item) {
    document.getElementById('galleryId').value = item.id;
    document.getElementById('existing_gallery_image').value = item.image_url;
    document.getElementById('galleryModalTitle').textContent = 'Ubah Foto Galeri';
    document.getElementById('galleryCaption').value = item.caption;
    
    if (item.image_url) {
        document.getElementById('galleryImagePreview').innerHTML = `
            <img src="${BASEURL}/img/gallery/${item.image_url}" style="height: 50px; border-radius: 4px;">
            <p style="font-size: 0.7rem;">Foto saat ini</p>
        `;
    } else {
        document.getElementById('galleryImagePreview').innerHTML = '';
    }
    
    openModal('galleryModal');
}

async function handleGallerySubmit(e) {
    e.preventDefault();
    
    const id = document.getElementById('galleryId').value;
    const url = id ? `${BASEURL}/api/updateGallery` : `${BASEURL}/api/addGallery`;
    
    const formData = new FormData(this);
    const response = await fetch(url, {
        method: 'POST',
        body: formData
    });
    
    const result = await response.json();
    
    if (result.status === 'success') {
        showToast('Galeri berhasil diperbarui!', 'success');
        loadGalleryAdmin();
        closeModal('galleryModal');
    } else {
        showToast('Gagal memproses galeri', 'error');
    }
}

async function deleteGalleryImage(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus foto ini?')) return;
    
    const response = await fetch(`${BASEURL}/api/deleteGallery/${id}`);
    const result = await response.json();
    
    if (result.status === 'success') {
        showToast('Foto berhasil dihapus!', 'success');
        loadGalleryAdmin();
    } else {
        showToast('Gagal menghapus foto', 'error');
    }
}
