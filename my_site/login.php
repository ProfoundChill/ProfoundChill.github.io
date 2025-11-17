<?php

// 1. Mandatory Session Setup and Inclusion (Part 3)
// Assumes includes/config.php contains only session_start() (critical for Osiris compatibility)
require_once 'includes/config.php'; 

// --- Helper: Redirection Function ---
function redirect(string $target_file) {
    // Use the logic from your original file, ensuring it terminates the script
    $host = $_SERVER['HTTP_HOST'];
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
    $path_suffix = strpos($host, 'osiris.ubishops.ca') !== false ? '/~oraga/my_site/' : '/'; 
    $redirect_url = $protocol . $host . $path_suffix . $target_file;
    header('Location: ' . $redirect_url);
    exit(); 
}
// ------------------------------------

// 2. Pre-Check: Already Logged In (Part 3)
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    redirect('to-do.php');
}

// 3. Logout Request Handling (Part 3)
$error = '';
$logout_success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy(); 
    session_start(); // Restart session to display a message on the current page
    $error = "Successfully logged out...";
    $logout_success = true;
}

// 4. Part 4 Constants and File Setup
$correct_hash = "b14e9015dae06b5e206c2b37178eac45e193792c5ccf1d48974552614c61f2ff"; 
$lockout_duration = 30; // 30 seconds
$max_attempts = 3; 
$file_path = 'login_attempts.json'; // CRITICAL: Update this to the absolute path for Osiris later.

// 4.1. Data Safety/Initialization (P4.1 FIX)
// Load existing attempts or initialize to an empty array ([]) if file is missing or corrupt.
$attempts = file_exists($file_path) 
    ? json_decode(file_get_contents($file_path) ?: '[]', true) 
    : []; 


// 5. Main Login Attempt Handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password']) && !$logout_success) {

    $password_input = $_POST['password'] ?? '';
    // P4.3 FIX: Ensure username is retrieved and defined
    $username_input = $_POST['username'] ?? ''; 

    if (empty($password_input) || empty($username_input)) {
        $error = "Both username and password are required for login.";
    } else {
        $input_hash = hash("sha256", $password_input);

        // 5.1 Initialize User Lockout Data
        if (!isset($attempts[$username_input])) {
            $attempts[$username_input] = [
                'attempts' => 0,
                'locked_until' => 0 
            ];
        }

        // 5.2 Lockout Check (P4.2 FIX: CRITICAL SEQUENCE)
        if ($attempts[$username_input]['locked_until'] > time()) { 
            $time_remaining = $attempts[$username_input]['locked_until'] - time();
            $error = "Account locked for 30 seconds. Please wait. Remaining time: {$time_remaining}s";
            // Do NOT proceed to password check. Jump to final save.
        } 
        
        // 5.3 Successful Login (Password check is nested here)
        else if ($input_hash === $correct_hash) {
            
            $_SESSION['is_logged_in'] = true; 
            setcookie('todo-username', $username_input, time() + (86400 * 30), '/'); // Part 2
            $attempts[$username_input]['attempts'] = 0; // Reset attempts on success
            
            // P4.1 FIX: Save attempts file on successful change before redirect
            file_put_contents($file_path, json_encode($attempts));

            redirect('to-do.php'); // Exits script
        } 

        // 5.4 Failed Login (Password check failed)
        else {
            $attempts[$username_input]['attempts'] += 1;
            
            if ($attempts[$username_input]['attempts'] >= $max_attempts) {
                $attempts[$username_input]['locked_until'] = time() + ($lockout_duration);
                $attempts[$username_input]['attempts'] = 0; // Reset count
                $error = "Too many attempts. Account locked for {$lockout_duration} seconds."; 
            } else {
                $error = "Wrong password. Attempt #{$attempts[$username_input]['attempts']}";
            }
        }

        // 5.5 Final Save (P4.1 FIX: File must be saved on ALL POST actions)
        // This runs after a failed login, or if a user was checked but was still locked out (5.2)
        file_put_contents($file_path, json_encode($attempts));
    }
}


// --- VIEW SECTION SETUP ---
// Retrieve username from cookie for pre-filling the form (Part 2)
$prefill_username = $_COOKIE['todo-username'] ?? ''; 

?>

<!DOCTYPE html>
<html>
<body>
    <div class="body_wrapper">

        <?php require_once 'nav.php'; ?>

        <h1 class="main-message">You are currently logged out...</h1>
        <br>

        <div class="form-content">
            <h2>Please log in...</h2>

            <?php if (!empty($error)): ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <input type="text" id="username" name="username" placeholder="Your username" required 
                       value="<?php echo htmlspecialchars($prefill_username); ?>"> 
                <br>
                <input type="password" id="password" name="password" placeholder="Your password" required> 
                
                <input type="submit" value="Login!">
            </form>
        </div>
    </div>
</body>
</html>