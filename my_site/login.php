<?php
// login.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. Mandatory Session and Configuration Setup (Part 3/Deployment Fix)
require_once 'config.php'; 

// 2. Core Data and Constants
$correct_hash = "b14e9015dae06b5e206c2b37178eac45e193792c5ccf1d48974552614c61f2ff";
$error = '';
$username = '';
$message = '';
$LOCKOUT_DURATION = 30; // Lockout time in seconds (as per instructions)
$MAX_ATTEMPTS = 3;     // Max failed attempts allowed
// Path to the attempts file (must be outside my_site/ to use ../)
$attempts_file = '/Applications/XAMPP/xamppfiles/htdocs/ProfoundChill.github.io/login_attempts.json'; 

// Initialize $user_data early for the VIEW section checks
$user_data = ['attempts' => 0, 'locked_until' => 0];

// --- Part 2.4: Read Cookie for Pre-filling ---
if (isset($_COOKIE['todo-username'])) {
    $username = htmlspecialchars($_COOKIE['todo-username']);
}

// 3. Part 3: Handle Logout Request (must run before any other session checks)
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

// 5. Part 4: Handle Login Attempt and Security Checks
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'], $_POST['username'])) {

    $username_input = $_POST['username'];
    $password_input = $_POST['password'];
    $input_hash = hash("sha256", $password_input);

    // ==========================================================
    
    // 5a. Load attempts data
    $attempts = [];
    if (file_exists($attempts_file)) {
        // Suppress warnings on empty/corrupted file
        $attempts = @json_decode(file_get_contents($attempts_file), true) ?? [];
    }

    // 5b. Initialize user data if missing
    if (!isset($attempts[$username_input])) {
        $attempts[$username_input] = [
            'attempts' => 0,
            'locked_until' => 0
        ];
    }
    // Get the reference to the specific user's data
    $user_data = &$attempts[$username_input]; 

    // 5c. Check for Lockout BEFORE password verification
    if ($user_data['locked_until'] > time()) {
        $lockout_time = $user_data['locked_until'] - time();
        $error = "Account locked for security reasons. Please try again in {$lockout_time} seconds.";
    } 
    // 5d. Proceed with authentication if not locked out
    else { 
        if ($input_hash === $correct_hash) {

            // SUCCESSFUL LOGIN: Reset attempt count
            $user_data['attempts'] = 0; 
            $user_data['locked_until'] = 0;
            
            // Part 3: Set session variable | Part 2: Set cookie
            $_SESSION['is_logged_in'] = true; 
            setcookie('todo-username', $username_input, time() + (86400 * 30), "/");

            // Save file data before redirecting
            file_put_contents($attempts_file, json_encode($attempts));
            
            header('Location: to-do.php');
            exit();
            
        } else {
            // FAILED LOGIN: Increment attempt count
            $user_data['attempts']++;
            $error = "The password is wrong. Attempt {$user_data['attempts']} of {$MAX_ATTEMPTS}.";

            // Check for Lockout condition
            if ($user_data['attempts'] >= $MAX_ATTEMPTS) {
                // Lock the user out, reset count
                $user_data['locked_until'] = time() + $LOCKOUT_DURATION;
                $user_data['attempts'] = 0;
                $error = "Max attempts reached. Account locked for {$LOCKOUT_DURATION} seconds.";
            }
            
            // Save back all values in the file after a failed attempt
            file_put_contents($attempts_file, json_encode($attempts));
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
            
            <?php if (!empty($message)): ?>
                <h2 style="color: black; margin-bottom: 5px;"><?php echo $message; ?></h2>
            <?php endif; ?>

            <h2 style="margin-top: 5px;">You are currently logged out...</h2>
            
            <?php if (!empty($error)): // Display error/lockout message in red: ?>
                <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form action="login.php" method="POST">
                
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>" required <?php echo ($user_data['locked_until'] ?? 0) > time() ? 'readonly' : ''; ?>> 
                <br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required <?php echo ($user_data['locked_until'] ?? 0) > time() ? 'readonly' : ''; ?>> 
                <br><br>
                <input type="submit" value="Login" class="submit-button" <?php echo ($user_data['locked_until'] ?? 0) > time() ? 'disabled' : ''; ?>>
            </form>
        </div>
        
    </div>
    <?php require_once 'footer.php'; ?>
</body>
</html>