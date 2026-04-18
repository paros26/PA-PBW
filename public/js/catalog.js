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
    currentJetSkiPrice = parseInt(jetSki.price_per_hour);
    
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
    const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // Hindari karakter yang membingungkan (O, 0, I, 1)
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
    formData.append('token', token); // Tambahkan token ke data yang dikirim ke database
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;

    try {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>⏳</span> Mengirim...';

        const response = await fetch(`${BASEURL}/api/addRental`, {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.status === 'success') {
            const customerName = document.getElementById('customer_name').value;
            const jetSkiName = document.getElementById('bookingJetSkiName').value;
            const duration = document.getElementById('duration').value;
            const rentalDate = document.getElementById('rental_date').value;
            const totalPrice = document.getElementById('bookingTotalPriceDisplay').textContent;
            
            // Pesan Konfirmasi
            alert(`Pemesanan Berhasil!\n\nTOKEN ANDA: ${token}\n\nHarap simpan token ini. Anda akan diarahkan ke WhatsApp untuk konfirmasi pembayaran.`);
            
            // Konfigurasi WhatsApp
            const adminPhone = '6285388832007'; // Ganti dengan nomor WhatsApp Admin Mahakam yang aktif
            const message = `*KONFIRMASI RENTAL JETSKI MAHAKAM*\n\n` +
                          `*Token:* ${token}\n` +
                          `*Nama:* ${customerName}\n` +
                          `*Paket:* ${jetSkiName}\n` +
                          `*Tanggal:* ${rentalDate}\n` +
                          `*Durasi:* ${duration} Sesi\n` +
                          `*Total:* ${totalPrice}\n\n` +
                          `Halo Admin, saya ingin mengonfirmasi pesanan rental saya dengan token di atas. Mohon instruksi pembayarannya.`;
            
            const waUrl = `https://wa.me/${adminPhone}?text=${encodeURIComponent(message)}`;
            
            // Buka di tab baru atau redirect
            window.location.href = waUrl;
        } else {
            alert(result.message || 'Gagal mengirim pesanan');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan sistem: ' + error.message);
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    }
}
