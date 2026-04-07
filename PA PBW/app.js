// Storage Key
const STORAGE_KEY = 'jetski_mahakam_data';
const ADMIN_CREDENTIALS = { username: 'admin', password: 'admin123' };

// Initial Data
const initialJetSkis = [
    {
        id: '1',
        name: 'Yamaha VX Cruiser',
        brand: 'Yamaha',
        model: 'VX Cruiser',
        year: 2023,
        pricePerHour: 500000,
        imageUrl: 'https://images.unsplash.com/photo-1768463852096-bf6dfab0f312?w=1080',
        available: true,
        description: 'Jet ski premium dengan performa tinggi dan kenyamanan maksimal'
    },
    {
        id: '2',
        name: 'Sea-Doo GTI SE',
        brand: 'Sea-Doo',
        model: 'GTI SE',
        year: 2023,
        pricePerHour: 550000,
        imageUrl: 'https://images.unsplash.com/photo-1618858227841-9beacd3b5f6f?w=1080',
        available: true,
        description: 'Jet ski modern dengan teknologi canggih untuk pengalaman yang tak terlupakan'
    },
    {
        id: '3',
        name: 'Yamaha GP1800R',
        brand: 'Yamaha',
        model: 'GP1800R',
        year: 2024,
        pricePerHour: 600000,
        imageUrl: 'https://images.unsplash.com/photo-1771282136960-345939d9f8d7?w=1080',
        available: true,
        description: 'Jet ski racing dengan kecepatan tinggi untuk petualangan ekstrem'
    }
];

const initialGallery = [
    {
        id: '1',
        imageUrl: 'https://images.unsplash.com/photo-1744288956623-d4e32d685562?w=1080',
        caption: 'Penyewaan jet ski di pantai Mahakam',
        date: '2024-01-15'
    },
    {
        id: '2',
        imageUrl: 'https://images.unsplash.com/photo-1769057266279-f2083dc330de?w=1080',
        caption: 'Petualangan seru bersama keluarga',
        date: '2024-02-20'
    },
    {
        id: '3',
        imageUrl: 'https://images.unsplash.com/photo-1759661324054-cfd24f2d47c2?w=1080',
        caption: 'Nikmati keindahan pantai tropis',
        date: '2024-03-07'
    }
];

// Initialize or get data from localStorage
function initData() {
    const stored = localStorage.getItem(STORAGE_KEY);
    if (stored) {
        try {
            return JSON.parse(stored);
        } catch (e) {
            return getDefaultData();
        }
    }
    return getDefaultData();
}

function getDefaultData() {
    return {
        jetSkis: initialJetSkis,
        rentals: [],
        gallery: initialGallery,
        isAdmin: false
    };
}

// Save data to localStorage
function saveData(data) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
}

// Get current data
function getData() {
    return initData();
}

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

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const navLinks = document.getElementById('navLinks');
    
    if (mobileMenuBtn && navLinks) {
        mobileMenuBtn.addEventListener('click', function() {
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

// Check if user is admin
function checkAdmin() {
    const data = getData();
    return data.isAdmin === true;
}

// Redirect if not admin
function requireAdmin() {
    if (!checkAdmin()) {
        window.location.href = 'login.html';
    }
}