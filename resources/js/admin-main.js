import { createApp } from 'vue';

const app = createApp({
    data() {
        return {
            BASEURL: window.BASEURL || '',
            apiUrl: window.BASEURL || '',
            jetskis: [],
            rentals: [],
            gallery: [],
            
            rentalSearchToken: '',
            rentalSortOrder: 'newest',
            
            reportYear: new Date().getFullYear(),
            reportMonth: new Date().getMonth().toString(),
            reportRentals: [],
            totalIncome: 0,
            incomeChart: null,

            formJetSki: {
                id: '', name: '', rider_type: 'single', route: '', price_per_hour: 0, description: '', is_available: true, existing_image: '', modalTitle: 'Tambah Paket Rental'
            },

            formRental: {
                id: '', jetski_id: '', customer_name: '', customer_phone: '', rental_date: '', sesi: 1, status: 'active', total_price: 0, existing_payment_proof: '', modalTitle: 'Tambah Transaksi Baru'
            },

            formGallery: {
                id: '', caption: '', existing_image: '', modalTitle: 'Unggah Foto Baru'
            },

            bsModals: {}
        };
    },
    computed: {
        filteredRentals() {
            let result = [...this.rentals];
            if (this.rentalSearchToken) {
                const search = this.rentalSearchToken.toLowerCase();
                result = result.filter(r => r.token && r.token.toLowerCase().includes(search));
            }
            result.sort((a, b) => {
                const dateA = new Date(a.rental_date);
                const dateB = new Date(b.rental_date);
                return this.rentalSortOrder === 'newest' ? dateB - dateA : dateA - dateB;
            });
            return result;
        },
        reportMonthName() {
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            return months[this.reportMonth] || '';
        }
    },
    watch: {
        'formRental.jetski_id': 'calculateTotalPrice',
        'formRental.sesi': 'calculateTotalPrice'
    },
    methods: {
        async loadAllData() {
            try {
                const base = this.apiUrl;
                const [resJs, resRt, resGl] = await Promise.all([
                    fetch(`${base}/api/jetskis`).then(r => r.json()),
                    fetch(`${base}/api/rentals`).then(r => r.json()),
                    fetch(`${base}/api/gallery`).then(r => r.json())
                ]);
                this.jetskis = resJs;
                this.rentals = resRt;
                this.gallery = resGl;
                this.generateIncomeReport();
            } catch (e) { console.error("Error loading data:", e); }
        },

        // ========== GALLERY METHODS ==========
        openGalleryModal() {
            this.formGallery = { id: '', caption: '', existing_image: '', modalTitle: 'Unggah Foto Galeri Baru' };
            const form = document.getElementById('galleryForm');
            if(form) form.reset();
            const preview = document.getElementById('galleryImagePreview');
            if(preview) preview.innerHTML = '';
            if(this.bsModals.gallery) this.bsModals.gallery.show();
        },
        editGallery(item) {
            this.formGallery = { id: item.id, caption: item.caption, existing_image: item.image_url, modalTitle: 'Ubah Data Galeri' };
            const preview = document.getElementById('galleryImagePreview');
            if(preview && item.image_url) {
                preview.innerHTML = `<img src="${this.apiUrl}/img/gallery/${item.image_url}" class="rounded mt-2 shadow-sm" style="height: 100px; width: 100%; object-fit: cover;">`;
            } else if(preview) {
                preview.innerHTML = '';
            }
            if(this.bsModals.gallery) this.bsModals.gallery.show();
        },
        async saveGallery() {
            const form = document.getElementById('galleryForm');
            const formData = new FormData(form);
            const url = this.formGallery.id ? `${this.apiUrl}/api/updateGallery` : `${this.apiUrl}/api/addGallery`;
            try {
                const res = await fetch(url, { method: 'POST', body: formData });
                const result = await res.json();
                if(result.status === 'success') {
                    this.showToast('Galeri berhasil disimpan');
                    this.loadAllData();
                    this.bsModals.gallery.hide();
                }
            } catch (e) { console.error(e); }
        },
        async deleteGalleryImage(id) {
            if(!confirm('Hapus foto ini dari galeri?')) return;
            try {
                const res = await fetch(`${this.apiUrl}/api/deleteGallery/${id}`);
                const result = await res.json();
                if(result.status === 'success') {
                    this.showToast('Foto berhasil dihapus');
                    this.loadAllData();
                }
            } catch (e) { console.error(e); }
        },

        // ========== RENTAL METHODS ==========
        openRentalModal() {
            this.formRental = { id: '', jetski_id: '', customer_name: '', customer_phone: '', rental_date: new Date().toISOString().split('T')[0], sesi: 1, status: 'active', total_price: 0, existing_payment_proof: '', modalTitle: 'Tambah Transaksi Baru' };
            const form = document.getElementById('rentalForm');
            if(form) form.reset();
            const preview = document.getElementById('paymentProofPreview');
            if(preview) preview.innerHTML = '';
            if(this.bsModals.rental) this.bsModals.rental.show();
        },
        editRental(item) {
            this.formRental = { ...item, existing_payment_proof: item.payment_proof, modalTitle: 'Ubah Transaksi' };
            const preview = document.getElementById('paymentProofPreview');
            if(preview && item.payment_proof) {
                preview.innerHTML = `<img src="${this.apiUrl}/img/payments/${item.payment_proof}" class="rounded mt-2" style="height: 60px;">`;
            } else if(preview) {
                preview.innerHTML = '';
            }
            if(this.bsModals.rental) this.bsModals.rental.show();
        },
        async saveRental() {
            const form = document.getElementById('rentalForm');
            const formData = new FormData(form);
            formData.set('total_price', this.formRental.total_price);
            const url = this.formRental.id ? `${this.apiUrl}/api/updateRental` : `${this.apiUrl}/api/addRental`;
            try {
                const res = await fetch(url, { method: 'POST', body: formData });
                if((await res.json()).status === 'success') {
                    this.showToast('Transaksi disimpan');
                    this.loadAllData();
                    this.bsModals.rental.hide();
                }
            } catch (e) { console.error(e); }
        },
        async deleteRental(id) {
            if(!confirm('Hapus transaksi ini?')) return;
            const res = await fetch(`${this.apiUrl}/api/deleteRental/${id}`);
            if((await res.json()).status === 'success') {
                this.showToast('Transaksi dihapus');
                this.loadAllData();
            }
        },
        calculateTotalPrice() {
            const selected = this.jetskis.find(j => j.id == this.formRental.jetski_id);
            const price = selected ? parseFloat(selected.price_per_hour) : 0;
            this.formRental.total_price = price * (parseInt(this.formRental.sesi) || 0);
        },
        viewPaymentProof(img) {
            const viewer = document.getElementById('viewerImage');
            if(viewer) viewer.src = `${this.apiUrl}/img/payments/${img}`;
            if(this.bsModals.viewer) this.bsModals.viewer.show();
        },

        // ========== JET SKI METHODS ==========
        openJetSkiModal() {
            this.formJetSki = { id: '', name: '', rider_type: 'single', route: '', price_per_hour: '', description: '', is_available: true, existing_image: '', modalTitle: 'Tambah Paket Rental Baru' };
            const form = document.getElementById('jetSkiForm');
            if(form) form.reset();
            const preview = document.getElementById('jetSkiImagePreview');
            if(preview) preview.innerHTML = '';
            if(this.bsModals.jetski) this.bsModals.jetski.show();
        },
        editJetSki(item) {
            this.formJetSki = { ...item, is_available: item.is_available == 1, existing_image: item.image_url, modalTitle: 'Ubah Paket Rental' };
            const preview = document.getElementById('jetSkiImagePreview');
            if(preview && item.image_url) {
                preview.innerHTML = `<img src="${this.apiUrl}/img/jetski/${item.image_url}" class="rounded mt-2" style="height: 60px;">`;
            } else if(preview) {
                preview.innerHTML = '';
            }
            if(this.bsModals.jetski) this.bsModals.jetski.show();
        },
        async saveJetSki() {
            const form = document.getElementById('jetSkiForm');
            const formData = new FormData(form);
            formData.set('is_available', this.formJetSki.is_available ? '1' : '0');
            const url = this.formJetSki.id ? `${this.apiUrl}/api/updateJetski` : `${this.apiUrl}/api/addJetski`;
            try {
                const res = await fetch(url, { method: 'POST', body: formData });
                if((await res.json()).status === 'success') {
                    this.showToast('Paket disimpan');
                    this.loadAllData();
                    this.bsModals.jetski.hide();
                }
            } catch (e) { console.error(e); }
        },
        async deleteJetSki(id) {
            if(!confirm('Hapus paket?')) return;
            const res = await fetch(`${this.apiUrl}/api/deleteJetski/${id}`);
            if((await res.json()).status === 'success') {
                this.showToast('Paket dihapus');
                this.loadAllData();
            }
        },

        // ========== INCOME REPORT ==========
        generateIncomeReport() {
            const year = parseInt(this.reportYear);
            const month = parseInt(this.reportMonth);
            this.reportRentals = this.rentals.filter(r => {
                const d = new Date(r.rental_date);
                return d.getFullYear() === year && d.getMonth() === month && r.status === 'completed';
            });
            this.totalIncome = this.reportRentals.reduce((sum, r) => sum + parseFloat(r.total_price), 0);
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const dailyData = Array(daysInMonth).fill(0);
            this.reportRentals.forEach(r => {
                const day = new Date(r.rental_date).getDate();
                dailyData[day - 1] += parseFloat(r.total_price);
            });
            this.updateChart(Array.from({length: daysInMonth}, (_, i) => i + 1), dailyData);
        },
        updateChart(labels, data) {
            const ctx = document.getElementById('incomeChart');
            if (!ctx) return;
            if (this.incomeChart) this.incomeChart.destroy();
            this.incomeChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Income', data: data, borderColor: '#ff8c00', backgroundColor: 'rgba(255, 140, 0, 0.1)', fill: true, tension: 0.4, borderWidth: 3
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#888' } },
                        x: { grid: { display: false }, ticks: { color: '#888' } }
                    }
                }
            });
        },

        // ========== UTILS ==========
        formatCurrency(val) { return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val || 0); },
        formatDate(dateStr) { return dateStr ? new Date(dateStr).toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' }) : '-'; },
        formatStatus(status) { return { active: 'Aktif', completed: 'Selesai', cancelled: 'Dibatalkan', deleted: 'Dihapus' }[status] || status; },
        getStatusBadgeClass(status) { return { active: 'bg-primary', completed: 'bg-success', cancelled: 'bg-danger', deleted: 'bg-secondary' }[status] || 'bg-light text-dark'; },
        showToast(msg) {
            const el = document.getElementById('toastMessage');
            if(el) el.textContent = msg;
            const toastEl = document.getElementById('liveToast');
            if(toastEl) { const toast = new bootstrap.Toast(toastEl); toast.show(); }
        },
        previewImage(event, previewId) {
            const file = event.target.files[0];
            const preview = document.getElementById(previewId);
            if (file && preview) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.innerHTML = `<img src="${e.target.result}" class="rounded mt-2 shadow-sm" style="height: 100px; width: 100%; object-fit: cover; border: 2px solid var(--primary);">`;
                };
                reader.readAsDataURL(file);
            }
        }
    },
    mounted() {
        // Simpan instance modal ke variabel global agar bisa diakses
        const modalIds = { jetski: 'jetSkiModal', rental: 'rentalModal', gallery: 'galleryModal', viewer: 'imageViewerModal' };
        for (const [key, id] of Object.entries(modalIds)) {
            const el = document.getElementById(id);
            if(el) this.bsModals[key] = new bootstrap.Modal(el);
        }
        
        // Init Year
        const yearSelect = document.getElementById('incomeYear');
        if(yearSelect) {
            const curr = new Date().getFullYear();
            for(let y = curr; y >= curr-5; y--) {
                const opt = document.createElement('option');
                opt.value = y; opt.textContent = y;
                yearSelect.appendChild(opt);
            }
        }
        
        // Tabs
        document.querySelectorAll('.admin-nav-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.dataset.tab;
                document.querySelectorAll('.admin-nav-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
                btn.classList.add('active');
                const target = document.getElementById(`${tab}-tab`);
                if(target) target.classList.add('active');
            });
        });
        
        // Forms
        const jsForm = document.getElementById('jetSkiForm');
        if(jsForm) jsForm.addEventListener('submit', (e) => { e.preventDefault(); this.saveJetSki(); });
        
        const rtForm = document.getElementById('rentalForm');
        if(rtForm) rtForm.addEventListener('submit', (e) => { e.preventDefault(); this.saveRental(); });

        const glForm = document.getElementById('galleryForm');
        if(glForm) glForm.addEventListener('submit', (e) => { e.preventDefault(); this.saveGallery(); });

        this.loadAllData();
    }
});

app.mount('#adminApp');
