<?php
// IKIGAI PERSONA: login.php - MODEL SECTION (Absolute Top)

// 1. Mandatory Inclusion and Session Start (Part 3)
require_once 'includes/config.php'; 

// --- Core Helper Function (Based on your original logic) ---
function redirect(string $target_file) {
    // This logic ensures correct pathing for both local (XAMPP/MAMP) and Osiris servers.
    $host = $_SERVER['HTTP_HOST'];
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
    $path_suffix = '/'; 

    if (strpos($host, 'osiris.ubishops.ca') !== false) {
        // Adjust this path_suffix if your web root is different (e.g., '/~yourusername/')
        $path_suffix = '/~oraga/my_site/'; 
    } 
    // ELSE: Path for local development (adjust as needed, e.g., '/lab7/')
    
    $redirect_url = $protocol . $host . $path_suffix . $target_file;
    header('Location: ' . $redirect_url);
    exit(); // CRITICAL: Terminate script after header redirect
}
// -------------------------------------------------------------------

// 2. Pre-Check: Already Logged In (Part 3)
// Zero Margin for Error: If logged in, prevent all further processing. [cite: 155]
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    redirect('to-do.php');
}

// 3. Logout Request Handling (Part 3)
$error = '';
$logout_success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy(); // Terminate the session [cite: 162]
    session_start(); // Start new session to display message [cite: 163]
    $error = "Successfully logged out..."; [cite: 163]
    $logout_success = true;
}

// 4. Constants and File Path Setup (Part 4)
$correct_hash = "b14e9015dae06b5e206c2b37178eac45e193792c5ccf1d48974552614c61f2ff"; // Hash for "CS203"
$lockout_duration = 30; 
$max_attempts = 3; 

// CRITICAL PATH BLOCKER: Must be updated for Osiris. Use local path for now.
$file_path = 'login_attempts.json'; 

// Initialize attempts structure.
$attempts = []; 
if (file_exists($file_path)) {
    // Load existing attempts (uses '[]' as fallback if file content is malformed) [cite: 189]
    $attempts = json_decode(file_get_contents($file_path), true) ?: []; 
}


// 5. Main Login Attempt Handling (Model Logic)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password']) && !$logout_success) {

    // 5.1 Input Validation (Part 3)
    $password_input = $_POST['password'] ?? '';
    $username_input = $_POST['username'] ?? ''; // New username input

    if (empty($password_input) || empty($username_input)) {
        $error = "Both username and password are required for login."; [cite: 164]
    } else {
        $input_hash = hash("sha256", $password_input);

        // 5.2 Initialize User Lockout Data (Part 4)
        if (!isset($attempts[$username_input])) {
            $attempts[$username_input] = [
                'attempts' => 0,
                'locked_until' => 0 
            ];
        }

        // 5.3 Lockout Check (CRITICAL SEQUENCE: Must be before password check) (Part 4)
        if ($attempts[$username_input]['locked_until'] > time()) { 
            $time_remaining = $attempts[$username_input]['locked_until'] - time();
            $error = "Locked out, sorry. Remaining time: {$time_remaining}"; [cite: 201]
            // Proceed to 5.6 (Save) and exit the POST logic.
        } 
        
        // 5.4 Successful Login (Part 2 & 3)
        else if ($input_hash === $correct_hash) {
            
            $_SESSION['is_logged_in'] = true; // Set session [cite: 154]
            setcookie('todo-username', $username_input, time() + (86400 * 30), '/'); // Set cookie [cite: 138]
            $attempts[$username_input]['attempts'] = 0; // Reset attempts on success
            
            // IMPORTANT: Save attempts file before redirect
            file_put_contents($file_path, json_encode($attempts)); [cite: 202, 203]

            redirect('to-do.php'); // Exits script
        } 

        // 5.5 Failed Login (Part 4)
        else {
            $attempts[$username_input]['attempts'] += 1; [cite: 195, 196]
            
            if ($attempts[$username_input]['attempts'] >= $max_attempts) {
                $attempts[$username_input]['locked_until'] = time() + ($lockout_duration); [cite: 198]
                $attempts[$username_input]['attempts'] = 0; // Reset count
                $error = "Three wrong attempts. Locked out for {$lockout_duration} secs."; 
            } else {
                $error = "Wrong password. Try again. This is your attempt #{$attempts[$username_input]['attempts']}"; [cite: 203]
            }
            // Proceed to 5.6 (Save attempts).
        }

        // 5.6 Save Attempts (Zero Margin for Error: File must be saved on all POST actions)
        file_put_contents($file_path, json_encode($attempts)); [cite: 202, 203]
    }
}


// --- VIEW SECTION (Below DOCTYPE, only simple PHP/HTML) ---

// Retrieve username from cookie for pre-filling the form (Part 2) [cite: 141]
$prefill_username = $_COOKIE['todo-username'] ?? ''; 

?>
<!DOCTYPE html>
<html>
<head>
    <title>To-Do List Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="my_style.css"> 
    <style> 
        .error-message { color: red; font-weight: bold; }
        .main-message { font-size: 2em; }
    </style>
</head>
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