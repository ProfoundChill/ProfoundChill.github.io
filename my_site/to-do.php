<?php

require_once 'config.php'; // Includes session_start()

// Part 3: Access Control - If not logged in, redirect to login page
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Part 2.3: Get username from the cookie (Runs only if access is granted)
$username = 'My'; 
if (isset($_COOKIE['todo-username'])) {
    $username = htmlspecialchars($_COOKIE['todo-username']) . "'s"; 
}
$page_title = $username . " To-Do List!"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="my_style.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style> 
        .logout-form {
            position: absolute;
            top: 15px; 
            right: 15px; 
        }
    </style>
</head>
<body>
    <div class="body_wrapper">
        
        <?php require_once 'nav.php'; ?>
        
        <form action="login.php" method="POST" class="logout-form">
            <input type="hidden" name="logout" value="1"> 
            <input type="submit" value="Log out" class="submit-button">
        </form>

        <h1><?php echo $page_title; ?></h1> 
        
        <div class="form-content" style="background-color: #ffc399; padding: 20px;">
            <h2>Add a to-do item!</h2>
            <form id="add-item-form"> 
                <input type="text" id="todo-input" placeholder="Get a gift for hubby's anniversary">
                <input type="button" value="Add Item" onclick="addItem()">
            </form>
        </div>

        <div class="content-box">
            <h2>My To-Do list this week!</h2>
            <ul id="todo-list-container">
            </ul>
        </div>
        
    </div>
  
    <?php require_once 'footer.php'; ?>
    
</body>
</html>