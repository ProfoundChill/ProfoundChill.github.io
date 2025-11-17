<?php

// =================================================================
// 🚨 MODEL SECTION (Part 3 Updates)
// =================================================================

// 1. Mandatory Session and Configuration Setup
require_once 'config.php'; // Includes session_start() [cite: 55, 56]

// 2. Core Data
$correct_hash = "b14e9015dae06b5e206c2b37178eac45e193792c5ccf1d48974552614c61f2ff";
$error = '';
$username = '';
$message = ''; // New variable to display successful logout message [cite: 66]

// --- Part 2.4: Read Cookie for Pre-filling ---
if (isset($_COOKIE['todo-username'])) {
    $username = htmlspecialchars($_COOKIE['todo-username']);
}

// 3. Part 3: Handle Logout Request (Before any other checks)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) { // Checking for 'logout' signal
    session_destroy(); // Destroy the existing session 
    session_start();   // Start a new session immediately [cite: 66]
    $message = "Successfully logged out..."; // Display confirmation message [cite: 66]
    // Note: Cookie (username) intentionally remains for pre-filling the form.
} 
// 4. Part 3: Check If User is Already Logged In
else if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    // If user is already logged in via session, skip password check and redirect 
    header('Location: to-do.php');
    exit();
}


// 5. Part 3: Handle Login Attempt (Only if not logging out or already logged in)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'], $_POST['username'])) {

    $username_input = $_POST['username'];
    $password_input = $_POST['password'];

    $input_hash = hash("sha256", $password_input);

    // Verify if the entered password's hash matches the correct hash
    if ($input_hash === $correct_hash) {

        // Set session variable to true 
        $_SESSION['is_logged_in'] = true; 
        
        // Part 2.2: Successful Login - Create "todo-username" Cookie
        setcookie('todo-username', $username_input, time() + (86400 * 30), "/");

        // Redirection Logic
        header('Location: to-do.php');
        exit();
        
    } else {
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

        <?php require_once 'nav.php'; // VIEW Section begins ?>

        <h1 class="form-title">Secure Login</h1>

        <div class="form-content">
            
            [cite_start]<?php if (!empty($message)): // Display success message if logged out[cite: 73]?>
                <h2 style="color: black; margin-bottom: 5px;">
                    <?php echo $message; ?>
                </h2>
            <?php endif; ?>

            <h2 style="margin-top: 5px;">You are currently logged out...</h2>
            <p>Please log in...</p>

            <?php if (!empty($error)): // Display error if logic dictates one: ?>
                <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form action="login.php" method="POST">
                
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>" required> 
                <br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required> 
                <br><br>
                <input type="submit" value="Login" class="submit-button">
            </form>
        </div>
        
    </div>
    <?php require_once 'footer.php'; ?>
</body>
</html>