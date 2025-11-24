/*
    FILENAME: theme.js
    PURPOSE: Handles the Light/Dark Mode toggle functionality (Optional Item #4).
    WHY: Separates presentation logic from PHP/HTML as required by the rubric.
*/
 
// Function to set the theme based on local storage preference
function applyTheme() {
    const body = document.body;
    const isDarkMode = localStorage.getItem('theme') === 'dark';
    const toggleButton = document.getElementById('theme-toggle');
    const icon = toggleButton ? toggleButton.querySelector('i') : null;

    // Apply or remove the 'dark-mode' class
    if (isDarkMode) {
        body.classList.add('dark-mode');
        // Change icon to sun
        if (icon) {
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        }
    } else {
        body.classList.remove('dark-mode');
        // Change icon to moon
        if (icon) {
            icon.classList.remove('fa-sun');
            icon.classList.add('fa-moon');
        }
    }
}

// Function called when the button is clicked
function toggleTheme() {
    const body = document.body;
    // Check current state
    const isCurrentlyDark = body.classList.contains('dark-mode');

    // Toggle the theme in local storage
    if (isCurrentlyDark) {
        localStorage.setItem('theme', 'light');
    } else {
        localStorage.setItem('theme', 'dark');
    }
    
    // Apply the new theme immediately
    applyTheme();
}

// CRITICAL: Apply the theme when the page finishes loading to enforce persistence
document.addEventListener('DOMContentLoaded', applyTheme);