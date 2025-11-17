<?php

// 1. Mandatory Session and Configuration Setup
require_once 'config.php'; // Includes session_start()

// 2. Core Data
$correct_hash = "b14e9015dae06b5e206c2b37178eac45e193792c5ccf1d48974552614c61f2ff";
$error = '';
$username = '';
$message = ''; // New variable to display successful logout message 

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
    $user_attempts = &$attempts[$username_input]; 

    if ($user_attempts['locked_until'] > $current_time) {
        $remaining_time = $user_attempts['locked_until'] - $current_time;
        // THIS IS THE SPECIFIC MESSAGE FOR LOCKOUT
        $error = "Locked out, sorry. Remaining time: {$remaining_time}";

        // --- Part 4.8: Save back all values in the file (even if locked out) ---
        file_put_contents($file, json_encode($attempts)); 
        
    } else {
        // --- Not locked out: proceed to password verification ---

        if ($input_hash === $correct_hash) {
            
            // Successful Login: Reset attempts for this user
            $user_attempts['attempts'] = 0;
            $user_attempts['locked_until'] = 0; 
            
            $_SESSION['is_logged_in'] = true; 
            setcookie('todo-username', $username_input, time() + (86400 * 30), "/");

            header('Location: to-do.php');
            exit();
            
        } else {
            // Wrong password logic

            // --- Part 4.5: Add 1 to that user's value: ---
            $user_attempts['attempts'] += 1;

            // --- Part 4.6: If this value reaches 3, lock them out, reset the count and print an explanation. ---
            if ($user_attempts['attempts'] >= $max_attempts) {
                
                // Lock out for 30 seconds
                $user_attempts['locked_until'] = $current_time + 30;
                $user_attempts['attempts'] = 0; 
                
                // THIS IS THE SPECIFIC MESSAGE FOR LOCKOUT TRIGGER
                $error = "Three wrong attempts. Locked out for 30 secs.";

            } else {
                $error = "Wrong password. Try again. This is your attempt # " . $user_attempts['attempts'];
            }
        }

        // --- Part 4.8: Before finishing the code, save back all values in the file ---
        file_put_contents($file, json_encode($attempts));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Secure Login</title>
    </head>
<body>

<div class="header-nav">...</div>

<div class="secure-login-container">
    <h2>Secure Login</h2>
    <div class="login-box">
        <h3>You are currently logged out...</h3>

        <?php if ($message): ?>
            <p style="color: green;"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <?php if ($error): ?>
            <p style="color: red; font-weight: bold;"><?php echo htmlspecialchars($error); ?></p>
        <?php else: ?>
            <p>Please log in.</p>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <p>Username:</p>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>

            <p>Password:</p>
            <input type="password" name="password" required>

            <button type="submit" name="login">Login</button>
        </form>
    </div>
</div>

</body>
</html>