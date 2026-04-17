// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(amount);
}

// Format date
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
}

// Show toast notification
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    if (!toast) return;
    
    toast.textContent = message;
    toast.className = `toast ${type} show`;
    
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}

// Navbar smart scroll (hide on scroll down, show on scroll up)
let lastScrollTop = 0;
const navbar = document.querySelector('.navbar');

window.addEventListener('scroll', function() {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    // Add scrolled class for glassmorphism background
    if (scrollTop > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }

    // Hide/Show logic
    if (scrollTop > lastScrollTop && scrollTop > 100) {
        // Scrolling down
        navbar.style.transform = 'translateY(-100%)';
    } else {
        // Scrolling up
        navbar.style.transform = 'translateY(0)';
    }
    
    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
});

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const navLinks = document.getElementById('navLinks');
    
    if (mobileMenuBtn && navLinks) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenuBtn.classList.toggle('active');
            navLinks.classList.toggle('active');
        });
    }
});

// Close modal
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
    }
}

// Open modal
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
    }
}

// ========== BOOKING MANAGEMENT ==========

let selectedJetSki = null;

function openBookingModal(jetSki) {
    selectedJetSki = jetSki;
    
    document.getElementById('bookingJetSkiId').value = jetSki.id;
    document.getElementById('bookingJetSkiName').value = jetSki.name;
    document.getElementById('duration').value = 1;
    
    // Update display with rider type and route
    const riderText = jetSki.rider_type === 'single' ? '👤 Single Rider' : '👥 Couple Rider';
    const detailText = `${riderText} | 📍 ${jetSki.route || 'Rute menyesuaikan'}`;
    
    const detailElement = document.getElementById('bookingPackageDetails');
    if (detailElement) detailElement.textContent = detailText;
    
    updateBookingTotalPrice();
    openModal('bookingModal');
}

function updateBookingTotalPrice() {
    if (!selectedJetSki) return;
    
    const duration = parseInt(document.getElementById('duration').value) || 0;
    const total = selectedJetSki.price_per_hour * duration;
    
    document.getElementById('bookingTotalPrice').value = total;
    document.getElementById('bookingTotalPriceDisplay').textContent = formatCurrency(total);
}

// Handle booking form submission
document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('bookingForm');
    const durationInput = document.getElementById('duration');
    
    if (durationInput) {
        durationInput.addEventListener('input', updateBookingTotalPrice);
    }
    
    if (bookingForm) {
        bookingForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const response = await fetch(`${BASEURL}/api/addRental`, {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.status === 'success') {
                alert('Pesanan berhasil dibuat! Silakan hubungi admin via WhatsApp untuk konfirmasi pembayaran.');
                // Redirect to WhatsApp with order details
                const waMessage = `Halo Admin Jetski Mahakam, saya ingin konfirmasi pesanan:
Nama: ${formData.get('customer_name')}
Paket: ${selectedJetSki.name}
Tanggal: ${formData.get('rental_date')}
Durasi: ${formData.get('duration')} sesi
Total: ${formatCurrency(formData.get('total_price'))}`;
                
                window.open(`https://wa.me/628123456789?text=${encodeURIComponent(waMessage)}`, '_blank');
                closeModal('bookingModal');
            } else {
                alert(result.message || 'Gagal memproses pesanan. Silakan coba lagi.');
            }
        });
    }
});
