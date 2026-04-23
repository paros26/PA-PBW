        </div> <!-- Closes admin-main-wrapper -->
    </div> <!-- Closes adminApp -->

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="background: var(--card-bg); border: 1px solid var(--primary);">
            <div class="toast-header bg-dark text-white border-bottom border-secondary">
                <i class="bi bi-info-circle-fill text-primary me-2"></i>
                <strong class="me-auto">Sistem Mahakam</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body text-white" id="toastMessage"></div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASEURL; ?>/js/app.js"></script>
    <script type="module" src="<?= BASEURL; ?>/js/admin.js"></script>
    
    <script>
        // Enhanced Sidebar Toggle Logic
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        
        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                sidebar.classList.toggle('show');
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (e) => {
                if (window.innerWidth <= 992 && sidebar.classList.contains('show') && !sidebar.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            });
        }
    </script>
</body>
</html>
