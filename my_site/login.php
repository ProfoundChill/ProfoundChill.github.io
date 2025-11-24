<?php

// 1. Mandatory Session and Configuration Setup
require_once 'config.php'; // Includes session_start()

// 2. Core Data
$correct_hash = "b14e9015dae06b5e206c2b37178eac45e193792c5ccf1d48974552614c61f2ff";
$error = '';
$username = '';
$message = ''; // Variable to display successful logout message 


// --- Part 4: Locking Mechanism Setup ---
$file = 'login_attempts.json'; 
$max_attempts = 3;

// 3. Part 2.4: Read Cookie for Pre-filling
if (isset($_COOKIE['todo-username'])) {
    $username = htmlspecialchars($_COOKIE['todo-username']);
}

// 4. Part 3: Handle Logout Request (Before any other checks)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy();
    session_start();
    $message = "Successfully logged out...";
} 
// 5. Part 3: Check If User is Already Logged In
else if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    // If user is already logged in via session, skip password check and redirect 
    header('Location: to-do.php');
    exit();
}

// 6. Part 3 & 4: Handle Login Attempt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'], $_POST['username'])) {

    $username_input = $_POST['username'];
    $password_input = $_POST['password'];
    $input_hash = hash("sha256", $password_input);

    // --- Part 4.3a: Load the file's data. Else, set $attempts to an empty array. ---
    if (file_exists($file)) {
        $attempts = json_decode(file_get_contents($file), true);
    } else {
        $attempts = [];
    }

    // --- Part 4.4: Verify if that user exists in your file. Else, create it. ---
    if (!isset($attempts[$username_input])) {
        $attempts[$username_input] = [
            'attempts' => 0,
            'locked_until' => 0
        ];
    }

    // --- Part 4.7: Before verifying the password, check if that user is locked out: ---
    $current_time = time();
    $user_attempts = &$attempts[$username_input]; // Use reference for easier updating

    if ($user_attempts['locked_until'] > $current_time) {
        $remaining_time = $user_attempts['locked_until'] - $current_time;
        // **This is the lockout message you asked for!**
        $error = "Locked out, sorry. Remaining time: {$remaining_time} seconds."; 

        // --- Part 4.8: Save back all values in the file (even if locked out) ---
        file_put_contents($file, json_encode($attempts)); 
        
    } else {
        // --- Not locked out: proceed to password verification ---

        if ($input_hash === $correct_hash) {
            
            // Successful Login: Reset attempts for this user
            $user_attempts['attempts'] = 0;
            $user_attempts['locked_until'] = 0; 
            
            $_SESSION['is_logged_in'] = true; 
            
            // Part 2.2: Successful Login - Create "todo-username" Cookie
            setcookie('todo-username', $username_input, time() + (86400 * 30), "/");

            // Redirection Logic
            header('Location: to-do.php');
            exit();
            
        } else {
            // Wrong password logic

            // --- Part 4.5: Add 1 to that user's value: ---
            $user_attempts['attempts'] += 1;

            // --- Part 4.6: Lock them out if max attempts reached ---
            if ($user_attempts['attempts'] >= $max_attempts) {
                
                // Lock out for 30 seconds
                $user_attempts['locked_until'] = $current_time + 30;
                $user_attempts['attempts'] = 0; // Reset count
                
                // **This is the max attempts message you asked for!**
                $error = "Three wrong attempts. Locked out for 30 seconds.";

            } else {
                $error = "Wrong password. Try again. This is your attempt # " . $user_attempts['attempts'];
            }
        }
        // --- Part 4.8: Save back all values in the file ---
        file_put_contents($file, json_encode($attempts));
        
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
            
        <?php if (!empty($message)): // Display success message if logged out ?>
        <h2 style="color: black; margin-bottom: 5px;">
            <?php echo htmlspecialchars($message); ?>
        </h2>
        <?php endif; ?>

         <h2 style="margin-top: 5px;">You are currently logged out...</h2>
    
         <?php if (!empty($error)): // Display error if logic dictates one: ?>
        <p style="color: red; font-weight: bold;"><?php echo htmlspecialchars($error); ?></p>
         <?php elseif (empty($message)): // Only show "Please log in..." if no errors AND no success message ?>
        <p>Please log in...</p>
         <?php endif; ?>
         
         <form action="login.php" method="POST">
        
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required> 
        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required> 
        <br><br>
        <input type="submit" value="Login" class="submit-button">
     </form>
        
    </div>
    </div>
    <?php require_once 'footer.php'; ?>
    <?php
// The header includes the start of the HTML, the CSS links, and the theme.js script.
require_once 'header.php'; 
// Any other necessary includes or page-specific logic here...
?>
</body>
</html>