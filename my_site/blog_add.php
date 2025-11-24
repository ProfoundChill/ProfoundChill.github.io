<?php
/*
    FILENAME: blog_add.php
    PURPOSE: View - A form to add a new blog post.
*/
session_start();

// REDIRECT: If not logged in, go to login
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

include 'header.php';
?>

<div class="container" style="max-width: 600px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px;">
    <h2>Add New Blog Post</h2>
    
    <form action="blog_controller.php" method="POST" id="add-post-form"> 
        <input type="hidden" name="action" value="add">
        
        <div style="margin-bottom: 15px;">
            <label for="title" style="display:block; margin-bottom:5px;">Title:</label>
            <input type="text" id="title" name="title" required style="width: 100%; padding: 8px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="content" style="display:block; margin-bottom:5px;">Content (Separate paragraphs with new lines):</label>
            <textarea id="content" name="content" rows="10" required style="width: 100%; padding: 8px;"></textarea>
        </div>
        
        <button type="submit" style="background-color: #28a745; color: #fff; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">Add Post</button>
        <a href="blog.php" style="margin-left: 10px; color: #007bff; text-decoration: none;">Cancel</a>
    </form>
</div>

<script src="autosave.js"></script>

<?php include 'footer.php'; ?>