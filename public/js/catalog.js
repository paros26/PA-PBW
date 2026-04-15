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

async function handleBookingSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch(`${BASEURL}/api/addRental`, {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.status === 'success') {
            const customerName = document.getElementById('customer_name').value;
            const jetSkiName = document.getElementById('bookingJetSkiName').value;
            const duration = document.getElementById('duration').value;
            
            // Success message
            alert('Pemesanan berhasil dicatat! Anda akan diarahkan ke WhatsApp untuk konfirmasi pembayaran.');
            
            // WhatsApp redirection
            const phoneNumber = '628123456789'; // Ganti dengan nomor WhatsApp Admin Anda
            const message = `Halo Admin Mahakam JetSki, saya ${customerName} ingin menyewa ${jetSkiName} selama ${duration} jam. Mohon info pembayaran selanjutnya.`;
            const waUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
            
            window.location.href = waUrl;
        } else {
            alert(result.message || 'Gagal mengirim pesanan');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan sistem');
    }
}
