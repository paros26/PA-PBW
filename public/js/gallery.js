// Load gallery on page load
document.addEventListener('DOMContentLoaded', function() {
    loadGallery();
});

function loadGallery() {
    const data = getData();
    const galleryGrid = document.getElementById('galleryGrid');
    
    if (!galleryGrid) return;
    
    if (data.gallery.length === 0) {
        galleryGrid.innerHTML = '<div style="text-align: center; padding: 3rem; color: #666;">Belum ada dokumentasi</div>';
        return;
    }
    
    galleryGrid.innerHTML = data.gallery.map(item => `
        <div class="gallery-item">
            <div class="gallery-image-wrapper">
                <img src="${item.imageUrl}" alt="${item.caption}" class="gallery-image"
                     onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'">
            </div>
            <div class="gallery-caption">
                <p class="gallery-title">${item.caption}</p>
                <p class="gallery-date">${formatDate(item.date)}</p>
            </div>
        </div>
    `).join('');
}
