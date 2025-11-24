<?php
/*
    FILENAME: blog_controller.php
    PURPOSE: Controller Layer - Handles all user input for the blog (Add, Delete, Edit).
    WHY: Keeps business logic separate from the Model and View.
*/

// CRITICAL: Ensure the Model is included FIRST so its functions are available.
require_once 'blog_model.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Security Check: Only allow logged-in users to perform ADD, DELETE, UPDATE actions
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    // If not logged in, redirect them away from this file.
    header('Location: login.php');
    exit();
}

// 2. Determine Action (Handles all GET and POST requests)
$action = $_POST['action'] ?? $_GET['action'] ?? null;

if ($action) {
    switch ($action) {
        
        case 'add':
            // MANDATORY ITEM #6: Handle Add New Post
            if (isset($_POST['title'], $_POST['content'])) {
                // Sanitize Input 
                $title = htmlspecialchars($_POST['title']);
                $content = htmlspecialchars($_POST['content']);
                
                if (!empty($title) && !empty($content)) {
                    // CRITICAL FIX: Calling the correct function defined in blog_model.php
                    if (save_new_blog_post($title, $content)) {
                        header('Location: blog.php?status=added');
                        exit();
                    }
                }
                // Redirect on failure
                header('Location: blog_add.php?error=save_failed');
                exit();
            }
            break;

        case 'delete':
            // MANDATORY ITEM #5: Handle Delete Post
            if (isset($_GET['id'])) {
                $id = htmlspecialchars($_GET['id']);
                
                // CRITICAL FIX: Calling the correct function defined in blog_model.php
                if (delete_blog_post($id)) {
                    header('Location: blog.php?status=deleted');
                    exit();
                } else {
                    header('Location: blog.php?error=delete_failed');
                    exit();
                }
            }
            break;

        case 'update':
            // OPTIONAL ITEM #6: Handle Post Update (Edit)
            if (isset($_POST['title'], $_POST['content'], $_POST['id'])) {
                $id = htmlspecialchars($_POST['id']);
                $title = htmlspecialchars($_POST['title']);
                $content = htmlspecialchars($_POST['content']);
                
                // Calling the correct function defined in blog_model.php
                if (update_blog_post($id, $title, $content)) {
                    header('Location: blog.php?status=updated');
                    exit();
                } else {
                    header('Location: blog.php?error=update_failed');
                    exit();
                }
            }
            break;
            
        default:
            // If an action is requested but not supported
            header('Location: blog.php?error=invalid_action');
            exit();
    }
}

// Default redirect if no action was performed (should not happen often)
header('Location: blog.php');
exit();