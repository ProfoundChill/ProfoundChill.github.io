<?php
/*
    FILENAME: blog_edit.php
    PURPOSE: View - Form to edit an existing blog post (Optional Item #6).
*/
session_start();
require_once 'blog_model.php'; 

// 1. Security Check and ID Validation
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: blog.php?error=no_post_id');
    exit();
}

$post_id = htmlspecialchars($_GET['id']);

// 2. Model Call: Fetch the post data
$post = get_single_post($post_id);

if (!$post) {
    header('Location: blog.php?error=post_not_found');
    exit();
}

// Prepare the content for the textarea: combine paragraphs back into a single string
// The content is stored as an array of paragraphs, so we join them back with double newlines.
$post_content = implode("\n\n", $post['paragraphs']);

include 'header.php'; 
?>

<div class="container" style="max-width: 600px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px;">
    <h2>Edit Blog Post: <?php echo htmlspecialchars($post['title']); ?></h2>
    
    <form action="blog_controller.php" method="POST"> <!-- Form to submit updates and changes -->
        <input type="hidden" name="action" value="update"> 
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($post['id']); ?>"> <!-- Hidden field for post ID -->
        
        <div style="margin-bottom: 15px;">
            <label for="title" style="display:block; margin-bottom:5px;">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required style="width: 100%; padding: 8px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="content" style="display:block; margin-bottom:5px;">Content (Separate paragraphs with new lines):</label>
            <textarea id="content" name="content" rows="10" required style="width: 100%; padding: 8px;"><?php echo htmlspecialchars($post_content); ?></textarea>
        </div>
        
        <button type="submit" style="background-color: #007bff; color: #fff; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">Save Changes</button>
        <a href="blog.php" style="margin-left: 10px; color: #007bff; text-decoration: none;">Cancel</a>
    </form>
</div>

<?php include 'footer.php'; ?>