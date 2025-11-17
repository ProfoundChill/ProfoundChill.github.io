<?php

// =================================================================
// PHP SCRIPT (MODEL SECTION) - All logic and data processing here
// =================================================================

// 1. Core Data
// Correct hash for "CS203" using sha256.
$correct_hash = "b14e9015dae06b5e206c2b37178eac45e193792c5ccf1d48974552614c61f2ff";
$error = '';
$username = ''; // Initialize username variable
$redirect_url = ''; // Variable for redirection target

// --- Part 2: Read Cookie for Pre-filling (Runs before form submission check) ---
if (isset($_COOKIE['todo-username'])) {
    // If the cookie exists, use its value to pre-fill the form (Part 2.4)
    $username = htmlspecialchars($_COOKIE['todo-username']);
}

// Check if the form was submitted via the POST method and critical fields are set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {

    // --- Part 2: Get submitted username and password ---
    $username_input = $_POST['username'] ?? ''; // Part 2.1 (We assume a 'username' input will be added)
    $password_input = $_POST['password'];

    // 2. Hash the user's input password for secure comparison
    $input_hash = hash("sha256", $password_input);

    // 3. Verify if the entered password's hash matches the correct hash
    if ($input_hash === $correct_hash) {

        // --- Part 2: Successful Login - Create Cookie (Part 2.2) ---
        // Set cookie for 30 days. The path '/' makes it available site-wide.
        setcookie('todo-username', $username_input, time() + (86400 * 30), "/");

        // --- Redirection Logic (FINAL, Simplified Dynamic Path) ---
        // This is simplified from the original complex logic, targeting the correct file.
        $target_file = 'to-do.php';

        $host = $_SERVER['HTTP_HOST'];
        
        // Original logic adapted for direct redirection to the file, which should be in /my_site/
        if (strpos($host, 'osiris.ubishops.ca') !== false) {
            // Osiris path: Use absolute path relative to user's home (e.g., /~oraga/my_site/to-do.php)
            $protocol = 'https://';
            // Assuming your user directory on Osiris is 'oraga'
            $path_suffix = '/~oraga/my_site/'; 
            $redirect_url = $protocol . $host . $path_suffix . $target_file;
        } else {
            // Local path: use local relative path (assuming files are in the same folder)
            $redirect_url = $target_file;
        }

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

        <?php require_once 'nav.php'; // VIEW Section begins ?>

        <h1 class="form-title">Secure Login</h1>

        <div class="form-content">
            <h2>Enter Username and Password</h2>

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