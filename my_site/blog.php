<?php
// ... PHP session and includes remain the same ...
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'header.php'; 
require_once 'blog_model.php'; 
$posts = get_blog_posts();
$is_admin = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
?>

<div class="blog-hero">
    <h1>The Developer's Blog</h1>
    <p>Documenting the journey of building a robust Web Architecture.</p>
</div>

<?php if ($is_admin): ?>
<div style="text-align: center; margin-top: 20px; margin-bottom: 20px;">
    <a href="blog_add.php" 
       style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block;">
        + Add New Post
    </a>
</div>
<?php endif; ?>

<div class="blog-container">

    <main class="blog-main">
        <?php
        if (!empty($posts)) {
            // Reverse array to show newest first
            $posts = array_reverse($posts);
            
            foreach ($posts as $post) {
                // ADDED CLASS: blog-article to apply card styling
                echo '<article id="' . htmlspecialchars($post['id']) . '" class="blog-article">';
                
                // MANDATORY ITEM #5 (Delete) and OPTIONAL ITEM #6 (Edit) Buttons
             if ($is_admin) {
    echo '<div style="position: absolute; top: 15px; right: 20px; font-size: 0.9rem;">';
    
    // EDIT Button (Links to the new edit page)
    echo '<a href="blog_edit.php?id=' . $post['id'] . '" 
             style="color: #007bff; text-decoration: none; margin-right: 15px;">
             [EDIT]
          </a>';

    // DELETE Button (Remains the same)
    echo '<a href="blog_controller.php?action=delete&id=' . $post['id'] . '" 
             onclick="return confirm(\'Are you sure you want to delete this post?\');"
             style="color: #dc3545; text-decoration: none;">
             [DELETE]
          </a>';
    echo '</div>';
}
                // Title & Date
                echo '<h2>' . htmlspecialchars($post['title']) . '</h2>';
                echo '<small>Posted: ' . htmlspecialchars($post['date']) . '</small>';
                
               // OPTIONAL ITEM #3: Read More / Collapsible Content
echo '<div class="post-content">';
$is_first = true;
$content_id = 'content-' . htmlspecialchars($post['id']);

foreach ($post['paragraphs'] as $paragraph) {
    if ($is_first) {
        // Show the first paragraph always
        echo '<p>' . htmlspecialchars($paragraph) . '</p>';
        
        // Start the collapsible section only if there are more paragraphs
        if (count($post['paragraphs']) > 1) {
            echo '<div id="' . $content_id . '" class="collapse">';
            $is_first = false; 
            continue; // Skip setting $is_first to false until after the loop starts
        }
    } else {
        // Show subsequent paragraphs inside the collapsible div
        echo '<p>' . htmlspecialchars($paragraph) . '</p>';
    }
}

// Close the collapsible div if it was opened
if (count($post['paragraphs']) > 1) {
    echo '</div>'; 

    // The Read More/Less button
    echo '<button class="btn btn-sm btn-link read-more-btn" type="button" 
               data-bs-toggle="collapse" data-bs-target="#' . $content_id . '" 
               aria-expanded="false" aria-controls="' . $content_id . '">';
    echo 'Read More...';
    echo '</button>';
}
echo '</div>';
                
                echo '</article>';
            }
        } else {
            echo '<p class="text-center p-5">No posts available. Log in to add one.</p>';
        }
        ?>
    </main>

    <aside class="blog-aside">
        <h3>Quick Navigation</h3>
        <ul>
            <?php
            if (!empty($posts)) {
                // Loop through reversed posts to match main content order
                foreach ($posts as $post) { 
                    echo '<li>';
                    echo '<a href="#' . htmlspecialchars($post['id']) . '">';
                    echo htmlspecialchars($post['title']);
                    echo '</a>';
                    echo '</li>';
                }
            }
            ?>
        </ul>
    </aside>

</div>

<?php include 'footer.php'; ?>