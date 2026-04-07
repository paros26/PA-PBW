// Handle login form
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            if (username === ADMIN_CREDENTIALS.username && password === ADMIN_CREDENTIALS.password) {
                // Set admin status
                const data = getData();
                data.isAdmin = true;
                saveData(data);
                
                showToast('Login berhasil!', 'success');
                setTimeout(() => {
                    window.location.href = 'admin.html';
                }, 1000);
            } else {
                showToast('Username atau password salah!', 'error');
            }
        });
    }
});
