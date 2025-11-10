<?php

// PHP Script: Part 4 - Handles login attempt and verifies the hashed password.

// The required password is "CS203"[cite: 54].
// 1. Correct hash for "CS203" using sha256[cite: 99, 101, 106].
$correct_hash = "b14e9015dae06b5e206c2b37178eac45e193792c5ccf1d48974552614c61f2ff";

$error = '';


// Check if the form was submitted via the POST method and the password field is set[cite: 61, 62].
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {

    $password_input = $_POST['password'];

    // 2. Hash the user's input password for secure comparison[cite: 97, 103, 106].
    $input_hash = hash("sha256", $password_input);

    // 3. Verify if the entered password's hash matches the correct hash[cite: 106].
    if ($input_hash === $correct_hash) {

        // --- Corrected Redirection Logic (Dynamic Path) ---
        $target_file = 'to-do.php'; // The destination file[cite: 63].
        $host = $_SERVER['HTTP_HOST'];
        $redirect_url = '';
        
        // Check if we are on the Osiris server[cite: 79].
        if (strpos($host, 'osiris.ubishops.ca') !== false) {
            // Case 2: Osiris Server path (e.g., https://osiris.ubishops.ca/~oraga/my_site/to-do.php)
            // Assumes files are in /~oraga/my_site/.
            $redirect_url = 'https://' . $host . '/~oraga/my_site/' . $target_file; 
        } else {
            // Case 1: Local XAMPP/LAMP setup (e.g., http://localhost/ProfoundChill.github.io/to-do.php)
            // Replace 'ProfoundChill.github.io' with your project folder name if different on localhost.
            $redirect_url = 'http://' . $host . '/ProfoundChill.github.io/' . $target_file;
        }
        
        // Redirect to the constructed URL[cite: 64, 84].
        header('Location: ' . $redirect_url);
        exit(); // Crucial: Terminate the script after sending the header[cite: 91].
        
    } else {
        // Set error message if the password comparison fails (incorrect password)[cite: 92].
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

        <?php require_once 'nav.php'; [cite_start]// Menu included with PHP[cite: 17, 18, 20, 56]. ?>

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
    <?php require_once 'footer.php'; [cite_start]// Footer included with PHP[cite: 21, 56]. ?>
</body>
</html>