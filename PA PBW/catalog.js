// Load catalog on page load
document.addEventListener('DOMContentLoaded', function() {
    loadCatalog();
});

function loadCatalog() {
    const data = getData();
    const catalogGrid = document.getElementById('catalogGrid');
    
    if (!catalogGrid) return;
    
    if (data.jetSkis.length === 0) {
        catalogGrid.innerHTML = '<div style="text-align: center; padding: 3rem; color: #666;">Belum ada unit jet ski tersedia</div>';
        return;
    }
    
    catalogGrid.innerHTML = data.jetSkis.map(jetSki => `
        <div class="catalog-item">
            <div class="catalog-item-header">
                <img src="${jetSki.imageUrl}" alt="${jetSki.name}" class="catalog-image" 
                     onerror="this.src='https://via.placeholder.com/400x250?text=No+Image'">
                <span class="badge ${jetSki.available ? 'badge-green' : 'badge-red'}">
                    ${jetSki.available ? 'Tersedia' : 'Sedang Disewa'}
                </span>
            </div>
            <div class="catalog-content">
                <h3 class="catalog-title">${jetSki.name}</h3>
                <p class="catalog-subtitle">${jetSki.brand} ${jetSki.model} (${jetSki.year})</p>
                <p class="catalog-description">${jetSki.description}</p>
                <div class="catalog-price">
                    <p class="catalog-price-label">Harga Sewa</p>
                    <p class="catalog-price-amount">
                        ${formatCurrency(jetSki.pricePerHour)}
                        <span class="catalog-price-unit">/jam</span>
                    </p>
                </div>
                <div class="catalog-details">
                    <div class="catalog-detail-row">
                        <span class="catalog-detail-label">Brand:</span>
                        <span class="catalog-detail-value">${jetSki.brand}</span>
                    </div>
                    <div class="catalog-detail-row">
                        <span class="catalog-detail-label">Tahun:</span>
                        <span class="catalog-detail-value">${jetSki.year}</span>
                    </div>
                    <div class="catalog-detail-row">
                        <span class="catalog-detail-label">Status:</span>
                        <span class="catalog-detail-value" style="color: ${jetSki.available ? '#16a34a' : '#dc2626'}">
                            ${jetSki.available ? 'Tersedia' : 'Sedang Disewa'}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}
