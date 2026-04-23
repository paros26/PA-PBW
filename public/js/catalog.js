// Load catalog on page load
document.addEventListener('DOMContentLoaded', function() {
    initCatalog();
});

let currentJetSkiPrice = 0;

function initCatalog() {
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        bookingForm.addEventListener('submit', handleBookingSubmit);
        document.getElementById('duration').addEventListener('input', updateBookingPrice);
    }
}

function openBookingModal(jetSki) {
    document.getElementById('bookingJetSkiId').value = jetSki.id;
    document.getElementById('bookingJetSkiName').value = jetSki.name;
    
    // Hidden field to store name for the success modal access
    let nameHidden = document.getElementById('booking_jetski_name_hidden');
    if(!nameHidden) {
        nameHidden = document.createElement('input');
        nameHidden.type = 'hidden';
        nameHidden.id = 'booking_jetski_name_hidden';
        document.getElementById('bookingForm').appendChild(nameHidden);
    }
    nameHidden.value = jetSki.name;

    currentJetSkiPrice = parseInt(jetSki.price_per_hour);
    
    // Update display with rider type and route
    const riderText = jetSki.rider_type === 'single' ? '👤 Single Rider' : '👥 Couple Rider';
    const detailText = `${riderText} | 📍 ${jetSki.route || 'Rute menyesuaikan'}`;
    
    const detailElement = document.getElementById('bookingPackageDetails');
    if (detailElement) detailElement.textContent = detailText;
    
    // Set default date to today
    document.getElementById('rental_date').value = new Date().toISOString().split('T')[0];
    document.getElementById('duration').value = 1;
    
    updateBookingPrice();
    openModal('bookingModal');
}

function updateBookingPrice() {
    const duration = parseInt(document.getElementById('duration').value) || 0;
    const total = currentJetSkiPrice * duration;
    
    document.getElementById('bookingTotalPriceDisplay').textContent = formatCurrency(total);
    document.getElementById('bookingTotalPrice').value = total;
}

function generateToken() {
    const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; 
    let token = 'JM-';
    for (let i = 0; i < 5; i++) {
        token += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return token;
}

async function handleBookingSubmit(e) {
    e.preventDefault();
    
    const token = generateToken();
    const formData = new FormData(this);
    formData.append('token', token); 
    
    const rawPrice = document.getElementById('bookingTotalPrice').value;
    formData.set('total_price', rawPrice);
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;

    try {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>⏳</span> Memproses...';

        const response = await fetch(`${BASEURL}/api/addRental`, {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.status === 'success') {
            const customerName = document.getElementById('customer_name').value;
            const jetSkiName = document.getElementById('booking_jetski_name_hidden').value;
            const duration = document.getElementById('duration').value;
            const rentalDate = document.getElementById('rental_date').value;
            const totalPriceDisplay = document.getElementById('bookingTotalPriceDisplay').textContent;
            
            // Inject to Success Modal
            document.getElementById('displayToken').textContent = token;
            document.getElementById('displayDetails').innerHTML = `
                <div style="display:flex; justify-content:space-between; margin-bottom:8px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom:5px;"><span style="color:#777;">Pelanggan:</span> <span style="color:white; font-weight:600;">${customerName}</span></div>
                <div style="display:flex; justify-content:space-between; margin-bottom:8px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom:5px;"><span style="color:#777;">Paket:</span> <span style="color:white; font-weight:600;">${jetSkiName}</span></div>
                <div style="display:flex; justify-content:space-between; margin-bottom:8px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom:5px;"><span style="color:#777;">Tanggal:</span> <span style="color:white; font-weight:600;">${rentalDate}</span></div>
                <div style="display:flex; justify-content:space-between;"><span style="color:#777;">Total Bayar:</span> <span style="color:var(--primary); font-weight:800;">${totalPriceDisplay}</span></div>
            `;
            
            const adminPhone = '62895705081807'; 
            const message = `*KONFIRMASI RENTAL JETSKI MAHAKAM*\n\n` +
                          `*Token:* ${token}\n` +
                          `*Nama:* ${customerName}\n` +
                          `*Paket:* ${jetSkiName}\n` +
                          `*Tanggal:* ${rentalDate}\n` +
                          `*Durasi:* ${duration} Sesi\n` +
                          `*Total:* ${totalPriceDisplay}\n\n` +
                          `Halo Admin, saya ingin mengonfirmasi pesanan rental saya dengan token di atas. Mohon instruksi pembayarannya.`;
            
            const waUrl = `https://wa.me/${adminPhone}?text=${encodeURIComponent(message)}`;
            
            document.getElementById('btnProceedWA').onclick = () => {
                window.location.href = waUrl;
            };

            // Switch Modals
            closeModal('bookingModal');
            const sModal = document.getElementById('successModal');
            sModal.style.display = 'flex';
            
        } else {
            alert(result.message || 'Gagal mengirim pesanan.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan sistem: ' + error.message);
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    }
}
