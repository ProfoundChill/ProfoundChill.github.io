<?php
/*
    FILENAME: blog_model.php
    PURPOSE: Model Layer - Handles all interaction with the blog_posts.json data file (CRUD operations).
    WHY: Separates data logic from the view (blog.php) and controller (blog_controller.php).
*/

// 1. Configuration and File Path
// CRITICAL: The file path must be relative to the executing script (e.g., blog_controller.php).
define('BLOG_FILE', 'blog_posts.json');

/**
 * Reads the blog posts from the JSON file.
 * @return array The array of posts, or an empty array if file is unreadable/empty.
 */
function get_blog_posts() {
    $file_path = BLOG_FILE;
    if (!file_exists($file_path)) {
        // If the file doesn't exist, create an empty one to prevent errors later.
        // This is a common step to ensure the script has *something* to read.
        file_put_contents($file_path, json_encode([]));
        return [];
    }

    $json_data = file_get_contents($file_path);
    if ($json_data === false || empty($json_data)) {
        return [];
    }
    
    $posts = json_decode($json_data, true);

    return is_array($posts) ? $posts : [];
}

/**
 * Saves a new post to the JSON file (Mandatory Item #6: ADD).
 */
function save_new_blog_post($title, $content) {
    $file_path = BLOG_FILE;
    $posts = get_blog_posts();

    // Generate a unique ID (based on time to ensure uniqueness)
    $new_id = 'post_' . time() . '_' . rand(100, 999);
    
    // Split content into paragraphs (using double newline separation)
    $paragraphs = array_filter(array_map('trim', explode("\n", $content)));

    $new_post = [
        'id' => $new_id,
        'date' => date('Y-m-d'),
        'title' => $title,
        'paragraphs' => $paragraphs,
    ];

    $posts[$new_id] = $new_post;

    $json_data = json_encode($posts, JSON_PRETTY_PRINT);
    
    // CRITICAL: file_put_contents handles the file writing.
    return file_put_contents($file_path, $json_data) !== false;
}

/**
 * Deletes a post from the JSON file (Mandatory Item #5: DELETE).
 */
function delete_blog_post($id) {
    $file_path = BLOG_FILE;
    $posts = get_blog_posts();

    if (!isset($posts[$id])) {
        return false;
    }

    unset($posts[$id]);

    $json_data = json_encode($posts, JSON_PRETTY_PRINT);
    return file_put_contents($file_path, $json_data) !== false;
}

/**
 * Retrieves a single post by its ID (Dependency for EDIT).
 */
function get_single_post($id) {
    $posts = get_blog_posts();
    return $posts[$id] ?? null;
}

/**
 * Updates an existing post in the JSON file (Optional Item #6: EDIT).
 */
function update_blog_post($id, $title, $content) {
    $file_path = BLOG_FILE;
    $posts = get_blog_posts();

    if (!isset($posts[$id])) {
        return false; // Post not found
    }

    // Split content back into paragraphs
    $paragraphs = array_filter(array_map('trim', explode("\n", $content)));

    // Update the post data
    $posts[$id]['title'] = $title;
    $posts[$id]['paragraphs'] = $paragraphs;
    
    $json_data = json_encode($posts, JSON_PRETTY_PRINT);
    // CRITICAL: file_put_contents handles the file writing.
    return file_put_contents($file_path, $json_data) !== false;
}