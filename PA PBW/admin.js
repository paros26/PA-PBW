document.addEventListener('DOMContentLoaded', function() {
    requireAdmin();
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
    
    // Logout button
    document.getElementById('logoutBtn').addEventListener('click', logout);
    
    // Jet Ski Management
    document.getElementById('addJetSkiBtn').addEventListener('click', () => openJetSkiModal());
    document.getElementById('jetSkiForm').addEventListener('submit', handleJetSkiSubmit);
    
    // Rental Management
    document.getElementById('addRentalBtn').addEventListener('click', () => openRentalModal());
    document.getElementById('rentalForm').addEventListener('submit', handleRentalSubmit);
    
    // Income Report
    document.getElementById('generateReportBtn').addEventListener('click', generateIncomeReport);
    
    // Gallery Management
    document.getElementById('addGalleryBtn').addEventListener('click', () => openGalleryModal());
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

// Logout
function logout() {
    const data = getData();
    data.isAdmin = false;
    saveData(data);
    showToast('Logout berhasil', 'success');
    setTimeout(() => {
        window.location.href = 'index.html';
    }, 1000);
}

// ========== JET SKI MANAGEMENT ==========

function loadJetSkis() {
    const data = getData();
    const tbody = document.getElementById('jetSkiTableBody');
    
    if (data.jetSkis.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 2rem; color: #666;">Belum ada data jet ski</td></tr>';
        return;
    }
    
    tbody.innerHTML = data.jetSkis.map(jetSki => `
        <tr>
            <td>
                <img src="${jetSki.imageUrl}" alt="${jetSki.name}" class="table-image"
                     onerror="this.src='https://via.placeholder.com/64?text=No+Image'">
            </td>
            <td><strong>${jetSki.name}</strong></td>
            <td>${jetSki.brand} ${jetSki.model}</td>
            <td>${jetSki.year}</td>
            <td>${formatCurrency(jetSki.pricePerHour)}</td>
            <td>
                <span class="status-badge ${jetSki.available ? 'status-available' : 'status-unavailable'}">
                    ${jetSki.available ? 'Tersedia' : 'Sedang Disewa'}
                </span>
            </td>
            <td>
                <div class="action-buttons">
                    <button class="btn-icon" onclick="editJetSki('${jetSki.id}')">✏️</button>
                    <button class="btn-icon delete" onclick="deleteJetSki('${jetSki.id}')">🗑️</button>
                </div>
            </td>
        </tr>
    `).join('');
}

function openJetSkiModal(id = null) {
    const modal = document.getElementById('jetSkiModal');
    const form = document.getElementById('jetSkiForm');
    const title = document.getElementById('jetSkiModalTitle');
    
    form.reset();
    document.getElementById('jetSkiId').value = '';
    document.getElementById('jetSkiYear').value = new Date().getFullYear();
    document.getElementById('jetSkiAvailable').checked = true;
    
    if (id) {
        const data = getData();
        const jetSki = data.jetSkis.find(js => js.id === id);
        
        if (jetSki) {
            title.textContent = 'Edit Jet Ski';
            document.getElementById('jetSkiId').value = jetSki.id;
            document.getElementById('jetSkiName').value = jetSki.name;
            document.getElementById('jetSkiBrand').value = jetSki.brand;
            document.getElementById('jetSkiModel').value = jetSki.model;
            document.getElementById('jetSkiYear').value = jetSki.year;
            document.getElementById('jetSkiPrice').value = jetSki.pricePerHour;
            document.getElementById('jetSkiImage').value = jetSki.imageUrl;
            document.getElementById('jetSkiDescription').value = jetSki.description;
            document.getElementById('jetSkiAvailable').checked = jetSki.available;
        }
    } else {
        title.textContent = 'Tambah Jet Ski Baru';
    }
    
    openModal('jetSkiModal');
}

function handleJetSkiSubmit(e) {
    e.preventDefault();
    
    const id = document.getElementById('jetSkiId').value;
    const jetSkiData = {
        name: document.getElementById('jetSkiName').value,
        brand: document.getElementById('jetSkiBrand').value,
        model: document.getElementById('jetSkiModel').value,
        year: parseInt(document.getElementById('jetSkiYear').value),
        pricePerHour: parseInt(document.getElementById('jetSkiPrice').value),
        imageUrl: document.getElementById('jetSkiImage').value,
        description: document.getElementById('jetSkiDescription').value,
        available: document.getElementById('jetSkiAvailable').checked
    };
    
    const data = getData();
    
    if (id) {
        // Update existing
        const index = data.jetSkis.findIndex(js => js.id === id);
        if (index !== -1) {
            data.jetSkis[index] = { ...data.jetSkis[index], ...jetSkiData };
            showToast('Jet ski berhasil diupdate!', 'success');
        }
    } else {
        // Add new
        data.jetSkis.push({
            id: Date.now().toString(),
            ...jetSkiData
        });
        showToast('Jet ski berhasil ditambahkan!', 'success');
    }
    
    saveData(data);
    loadJetSkis();
    closeModal('jetSkiModal');
}

function editJetSki(id) {
    openJetSkiModal(id);
}

function deleteJetSki(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus jet ski ini?')) return;
    
    const data = getData();
    data.jetSkis = data.jetSkis.filter(js => js.id !== id);
    saveData(data);
    loadJetSkis();
    showToast('Jet ski berhasil dihapus!', 'success');
}

// ========== RENTAL MANAGEMENT ==========

function loadRentals() {
    const data = getData();
    const tbody = document.getElementById('rentalsTableBody');
    
    if (data.rentals.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" style="text-align: center; padding: 2rem; color: #666;">Belum ada transaksi sewa</td></tr>';
        return;
    }
    
    tbody.innerHTML = data.rentals.map(rental => `
        <tr>
            <td><small>${rental.id.substring(0, 8)}</small></td>
            <td>${rental.jetSkiName}</td>
            <td>${rental.customerName}</td>
            <td>${rental.customerPhone}</td>
            <td>${formatDate(rental.rentalDate)}</td>
            <td>${rental.duration} jam</td>
            <td><strong>${formatCurrency(rental.totalPrice)}</strong></td>
            <td>
                <span class="status-badge status-${rental.status}">
                    ${rental.status === 'active' ? 'Aktif' : rental.status === 'completed' ? 'Selesai' : 'Dibatalkan'}
                </span>
            </td>
            <td>
                <div class="action-buttons">
                    <button class="btn-icon" onclick="editRental('${rental.id}')">✏️</button>
                </div>
            </td>
        </tr>
    `).join('');
    
    // Update rental jet ski select options
    updateRentalJetSkiOptions();
}

function updateRentalJetSkiOptions() {
    const data = getData();
    const select = document.getElementById('rentalJetSki');
    
    select.innerHTML = '<option value="">-- Pilih Jet Ski --</option>' +
        data.jetSkis.map(js => `
            <option value="${js.id}" data-price="${js.pricePerHour}">${js.name} - ${formatCurrency(js.pricePerHour)}/jam</option>
        `).join('');
}

function openRentalModal(id = null) {
    const modal = document.getElementById('rentalModal');
    const form = document.getElementById('rentalForm');
    const title = document.getElementById('rentalModalTitle');
    
    form.reset();
    document.getElementById('rentalId').value = '';
    document.getElementById('rentalDate').value = new Date().toISOString().split('T')[0];
    document.getElementById('rentalDuration').value = 1;
    document.getElementById('rentalStatus').value = 'active';
    document.getElementById('rentalTotalPrice').textContent = 'Rp 0';
    
    updateRentalJetSkiOptions();
    
    if (id) {
        const data = getData();
        const rental = data.rentals.find(r => r.id === id);
        
        if (rental) {
            title.textContent = 'Edit Transaksi Sewa';
            document.getElementById('rentalId').value = rental.id;
            document.getElementById('rentalJetSki').value = rental.jetSkiId;
            document.getElementById('rentalCustomerName').value = rental.customerName;
            document.getElementById('rentalCustomerPhone').value = rental.customerPhone;
            document.getElementById('rentalDate').value = rental.rentalDate;
            document.getElementById('rentalDuration').value = rental.duration;
            document.getElementById('rentalStatus').value = rental.status;
            calculateRentalPrice();
        }
    } else {
        title.textContent = 'Tambah Transaksi Sewa';
    }
    
    openModal('rentalModal');
}

function calculateRentalPrice() {
    const jetSkiSelect = document.getElementById('rentalJetSki');
    const duration = parseInt(document.getElementById('rentalDuration').value) || 0;
    const selectedOption = jetSkiSelect.options[jetSkiSelect.selectedIndex];
    const price = parseInt(selectedOption.dataset.price) || 0;
    
    const total = price * duration;
    document.getElementById('rentalTotalPrice').textContent = formatCurrency(total);
}

function handleRentalSubmit(e) {
    e.preventDefault();
    
    const id = document.getElementById('rentalId').value;
    const jetSkiSelect = document.getElementById('rentalJetSki');
    const jetSkiId = jetSkiSelect.value;
    const jetSkiName = jetSkiSelect.options[jetSkiSelect.selectedIndex].text.split(' - ')[0];
    const duration = parseInt(document.getElementById('rentalDuration').value);
    const price = parseInt(jetSkiSelect.options[jetSkiSelect.selectedIndex].dataset.price);
    
    const rentalData = {
        jetSkiId: jetSkiId,
        jetSkiName: jetSkiName,
        customerName: document.getElementById('rentalCustomerName').value,
        customerPhone: document.getElementById('rentalCustomerPhone').value,
        rentalDate: document.getElementById('rentalDate').value,
        duration: duration,
        totalPrice: price * duration,
        status: document.getElementById('rentalStatus').value
    };
    
    const data = getData();
    
    if (id) {
        // Update existing
        const index = data.rentals.findIndex(r => r.id === id);
        if (index !== -1) {
            data.rentals[index] = { ...data.rentals[index], ...rentalData };
            showToast('Transaksi berhasil diupdate!', 'success');
        }
    } else {
        // Add new
        data.rentals.push({
            id: Date.now().toString(),
            ...rentalData
        });
        showToast('Transaksi berhasil ditambahkan!', 'success');
    }
    
    saveData(data);
    loadRentals();
    closeModal('rentalModal');
}

function editRental(id) {
    openRentalModal(id);
}

// ========== INCOME REPORT ==========

function initIncomeReport() {
    const yearSelect = document.getElementById('incomeYear');
    const currentYear = new Date().getFullYear();
    
    // Populate year options
    for (let year = currentYear; year >= currentYear - 5; year--) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    }
    
    // Set current month
    document.getElementById('incomeMonth').value = new Date().getMonth().toString();
}

function generateIncomeReport() {
    const year = parseInt(document.getElementById('incomeYear').value);
    const month = parseInt(document.getElementById('incomeMonth').value);
    
    const data = getData();
    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    
    // Filter completed rentals for the selected month
    const filteredRentals = data.rentals.filter(r => {
        const rentalDate = new Date(r.rentalDate);
        return rentalDate.getFullYear() === year && 
               rentalDate.getMonth() === month &&
               r.status === 'completed';
    });
    
    // Calculate total income
    const totalIncome = filteredRentals.reduce((sum, r) => sum + r.totalPrice, 0);
    
    // Update summary
    document.getElementById('totalIncome').textContent = formatCurrency(totalIncome);
    document.getElementById('incomePeriod').textContent = `Bulan: ${monthNames[month]} ${year}`;
    
    // Update table
    const tbody = document.getElementById('incomeTableBody');
    
    if (filteredRentals.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align: center; padding: 2rem; color: #666;">Tidak ada transaksi selesai di bulan ini</td></tr>';
        return;
    }
    
    tbody.innerHTML = filteredRentals.map(rental => `
        <tr>
            <td>${formatDate(rental.rentalDate)}</td>
            <td>${rental.jetSkiName}</td>
            <td>${rental.customerName}</td>
            <td>${rental.duration} jam</td>
            <td><strong>${formatCurrency(rental.totalPrice)}</strong></td>
        </tr>
    `).join('');
}

// ========== GALLERY MANAGEMENT ==========

function loadGalleryAdmin() {
    const data = getData();
    const grid = document.getElementById('galleryAdminGrid');
    
    if (data.gallery.length === 0) {
        grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: #666;">Belum ada foto galeri</div>';
        return;
    }
    
    grid.innerHTML = data.gallery.map(item => `
        <div class="gallery-admin-item">
            <img src="${item.imageUrl}" alt="${item.caption}" class="gallery-admin-image"
                 onerror="this.src='https://via.placeholder.com/250x200?text=No+Image'">
            <div class="gallery-admin-content">
                <p class="gallery-admin-caption">${item.caption}</p>
                <p class="gallery-admin-date">${formatDate(item.date)}</p>
                <button class="btn-icon delete" onclick="deleteGalleryImage('${item.id}')" style="width: 100%;">
                    🗑️ Hapus
                </button>
            </div>
        </div>
    `).join('');
}

function openGalleryModal() {
    const form = document.getElementById('galleryForm');
    form.reset();
    openModal('galleryModal');
}

function handleGallerySubmit(e) {
    e.preventDefault();
    
    const imageData = {
        imageUrl: document.getElementById('galleryImage').value,
        caption: document.getElementById('galleryCaption').value,
        date: new Date().toISOString().split('T')[0]
    };
    
    const data = getData();
    data.gallery.push({
        id: Date.now().toString(),
        ...imageData
    });
    
    saveData(data);
    loadGalleryAdmin();
    closeModal('galleryModal');
    showToast('Foto berhasil ditambahkan!', 'success');
}

function deleteGalleryImage(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus foto ini?')) return;
    
    const data = getData();
    data.gallery = data.gallery.filter(g => g.id !== id);
    saveData(data);
    loadGalleryAdmin();
}