<?php

// PHP Script: Part 4 - Handles login attempt and verifies the hashed password.

// 1. Correct hash for "CS203" using sha256.
$correct_hash = "b14e9015dae06b5e206c2b37178eac45e193792c5ccf1d48974552614c61f2ff";

$error = '';


// Check if the form was submitted via the POST method and the password field is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {

    $password_input = $_POST['password'];

    // 2. Hash the user's input password for secure comparison
    $input_hash = hash("sha256", $password_input);

    // 3. Verify if the entered password's hash matches the correct hash
    if ($input_hash === $correct_hash) {

        // --- Redirection Logic (CORRECTED Dynamic Path) ---
        $host = $_SERVER['HTTP_HOST'];
        $target_file = 'to-do.php';

        // Case 1: Local XAMPP/LAMP setup
        if (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false) {
            $protocol = 'http://';
            // Local XAMPP/LAMP setup path: uses the repo name
            $path_suffix = '/ProfoundChill.github.io/';
        } else {
            // Case 2: Osiris/Web Server path (The Fix is here!)
            $protocol = 'https://';
            // **CORRECTED PATH**: Must include the /my_site/ subfolder
            $path_suffix = '/~oraga/my_site/'; 
        }

        // Construct the full URL and Redirect
        $BASE_URL = $protocol . $host . $path_suffix;
        $redirect_url = $BASE_URL . $target_file;
        
        header('Location: ' . $redirect_url);
        exit(); // Crucial: Terminate the script after sending the header
        
    } else {
        // Set error message if the password comparison fails (incorrect password)
        $error = "The password is wrong.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>To-Do List Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="my_style.css"> 
</head>
<body>
    <div class="body_wrapper">

        <?php require_once 'nav.php'; ?>

        <h1 class="form-title">Secure Login</h1>

        <div class="form-content">
            <h2>Enter Password to Access To-Do List</h2>

            <?php if (!empty($error)): ?>
                <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required> 
                <br><br>
                <input type="submit" value="Login" class="submit-button">
            </form>
        </div>
        
    </div>
    <?php require_once 'footer.php'; ?>