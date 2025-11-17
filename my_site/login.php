<?php

// 1. Mandatory Session and Configuration Setup
require_once 'config.php'; // Includes session_start() 

// 2. Core Data
$correct_hash = "b14e9015dae06b5e206c2b37178eac45e193792c5ccf1d48974552614c61f2ff";
$error = '';
$username = '';
$message = ''; 

// --- START: PART 4 SIMPLE CHANGES (SETUP) ---
$lockout_duration = 30; // 30 seconds
$max_attempts = 3; 

// Initialize the lockout array within the session
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = [];
}
// --- END: PART 4 SIMPLE CHANGES (SETUP) ---


// --- Part 2.4: Read Cookie for Pre-filling ---
if (isset($_COOKIE['todo-username'])) {
    $username = htmlspecialchars($_COOKIE['todo-username']);
}

// 3. Part 3: Handle Logout Request (Before any other checks)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) { 
    session_destroy(); 
    session_start();   
    $message = "Successfully logged out..."; 
} 
// 4. Part 3: Check If User is Already Logged In
else if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    header('Location: to-do.php');
    exit();
}


// 5. Part 3 & 4: Handle Login Attempt 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'], $_POST['username'])) {

    $username_input = $_POST['username'];
    $password_input = $_POST['password'];

    // --- START: PART 4 LOGIC INTEGRATION ---
    // 5.1 Initialize User Lockout Data
    if (!isset($_SESSION['login_attempts'][$username_input])) {
        $_SESSION['login_attempts'][$username_input] = ['attempts' => 0, 'locked_until' => 0];
    }
    
    // 5.2 CRITICAL: Lockout Check (MUST be first validation)
    if ($_SESSION['login_attempts'][$username_input]['locked_until'] > time()) { 
        $time_remaining = $_SESSION['login_attempts'][$username_input]['locked_until'] - time();
        $error = "Account locked. Remaining time: {$time_remaining}s";
    }

    $input_hash = hash("sha256", $password_input);

    // Verify if the entered password's hash matches the correct hash
    else if ($input_hash === $correct_hash) {
        
        // Reset attempts on successful login
        $_SESSION['login_attempts'][$username_input]['attempts'] = 0; 

        // Set session variable to true 
        $_SESSION['is_logged_in'] = true; 
        
        // Part 2.2: Successful Login - Create "todo-username" Cookie
        setcookie('todo-username', $username_input, time() + (86400 * 30), "/");

        // Redirection Logic
        header('Location: to-do.php');
        exit();
        
    } else {
        // Part 4 Failure Logic: Increment attempts and check for lock
        $_SESSION['login_attempts'][$username_input]['attempts'] += 1; 
        
        if ($_SESSION['login_attempts'][$username_input]['attempts'] >= $max_attempts) {
            $_SESSION['login_attempts'][$username_input]['locked_until'] = time() + ($lockout_duration);
            $_SESSION['login_attempts'][$username_input]['attempts'] = 0; 
            $error = "Too many attempts. Locked out for {$lockout_duration} seconds."; 
        } else {
            $error = "The password is wrong. Attempt #{$_SESSION['login_attempts'][$username_input]['attempts']}.";
        }
    }
    // --- END: PART 4 LOGIC INTEGRATION ---
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
            
           <?php if (!empty($message)): // Display success message if logged out[cite: 73]?>
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