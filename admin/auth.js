// Authentication check - Add this to the top of every admin page
function checkAdminAuth() {
    if (localStorage.getItem('adminLoggedIn') !== 'true') {
        window.location.href = 'login.html';
    }
}

// Logout function
function adminLogout() {
    localStorage.removeItem('adminLoggedIn');
    localStorage.removeItem('adminUsername');
    localStorage.removeItem('loginTime');
    window.location.href = 'login.html';
}

// Get current admin username
function getAdminUsername() {
    return localStorage.getItem('adminUsername') || 'Admin';
}
