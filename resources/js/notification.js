// Assuming this is in your Vite JS file
function toggleNotificationDropdown() {
    var dropdown = document.getElementById('notification-dropdown');
    dropdown.classList.toggle('active');
}

// Attach to the window object if needed
window.toggleNotificationDropdown = toggleNotificationDropdown;
