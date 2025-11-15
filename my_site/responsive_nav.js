/* JavaScript to toggle the navigation menu on small screens (Existing Function) */
function toggleMenu() {
    // 1. Get the navigation element
    const nav = document.querySelector('nav');
    
    // 2. Check if the 'responsive' class is currently on the nav element
    if (nav.classList.contains("responsive")) {
        // If it has 'responsive', remove it (hides the menu links)
        nav.classList.remove("responsive");
    } else {
        // If it doesn't have 'responsive', add it (shows the menu links)
        nav.classList.add("responsive");
    }
}

/* NEW: JavaScript to toggle the dropdown menu on click */
function toggleDropdown() {
    // 1. Get the dropdown content element using the new ID from nav.php
    const dropdownContent = document.getElementById("discoverDropdown");
    
    // 2. Toggle the 'show' class to display/hide the content
    dropdownContent.classList.toggle("show");
}

/* Optional: Close the dropdown if the user clicks outside of it */
window.onclick = function(event) {
    // Check if the click event did NOT happen on the dropdown button
    if (!event.target.matches('.dropbtn')) {
        const dropdown = document.getElementById("discoverDropdown");
        
        // If the dropdown is currently open (has the 'show' class), close it
        if (dropdown && dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
        }
    }
}