/*
    FILENAME: autosave.js
    PURPOSE: Implements auto-save functionality for the Add New Post form (Optional Item #5).
    WHY: Saves form data to localStorage on input, restoring it on load.
*/

document.addEventListener('DOMContentLoaded', function() {
    const titleField = document.getElementById('title');
    const contentField = document.getElementById('content');
    const form = document.getElementById('add-post-form');

    // 1. Restore Data on Load
    // Check if the fields exist (i.e., we are on blog_add.php)
    if (titleField && contentField) {
        titleField.value = localStorage.getItem('draft_title') || '';
        contentField.value = localStorage.getItem('draft_content') || '';
    }

    // 2. Auto-Save Data on Input
    if (titleField) {
        titleField.addEventListener('input', function() {
            localStorage.setItem('draft_title', titleField.value);
        });
    }

    if (contentField) {
        contentField.addEventListener('input', function() {
            localStorage.setItem('draft_content', contentField.value);
        });
    }

    // 3. Clear Data on Successful Submission
    // Prevents the draft from reappearing after the post is officially saved
    if (form) {
        form.addEventListener('submit', function() {
            // Note: This only clears on click, a successful submission relies on blog_controller.php logic.
            localStorage.removeItem('draft_title');
            localStorage.removeItem('draft_content');
        });
    }
});