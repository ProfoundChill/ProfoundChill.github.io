<?php
// SESSION CHECK: Ensure session is started to read login status
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get the current file name to highlight the active page
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav id="my-nav">
    <a href="#" class="icon" onclick="toggleMenu()">
        <i class="fa fa-bars"></i> 
    </a>
    
    <a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'current-page' : ''; ?> logo-link">
        <img src="images/logo.webp" alt="ProfoundChill Logo" class="nav-logo">
    </a>

    <div class="dropdown">
        <button class="dropbtn" onclick="toggleDropdown()">
            Discover me! &#9660;
        </button> 
        <div class="dropdown-content" id="discoverDropdown">
            <a href="my_vacation.php" class="<?php echo ($current_page == 'my_vacation.php') ? 'current-page' : ''; ?>">My Dream Vacation</a> 
            <a href="my_artistic_self.php" class="<?php echo ($current_page == 'my_artistic_self.php') ? 'current-page' : ''; ?>">My Artistic Self</a>
        </div>
    </div>
    
    <a href="marketplace.php" class="<?php echo ($current_page == 'marketplace.php') ? 'current-page' : ''; ?>">Marketplace</a> 
    <a href="my_form.php" class="<?php echo ($current_page == 'my_form.php') ? 'current-page' : ''; ?>">My Quiz Form</a> 
    
<a href="blog.php" class="<?php echo ($current_page == 'blog.php') ? 'current-page' : ''; ?>">Blog</a>

    <button id="theme-toggle" onclick="toggleTheme()" title="Toggle Light/Dark Mode"
            style="cursor: pointer; background: none; border: none; font-size: 1.2rem; margin-left: 10px; margin-right: 15px;">
        <i class="fas fa-moon"></i>
    </button>
    
    
    <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true): ?>
        <form action="login.php" method="POST" style="display:inline;">
            <button type="submit" name="logout" style="background:none; border:none; color:white; cursor:pointer; font-size:17px; padding: 14px 16px;">Logout</button>
        </form>
    <?php else: ?>
        <a href="login.php" class="<?php echo ($current_page == 'login.php') ? 'current-page' : ''; ?>">Login</a>
    <?php endif; ?>

</nav>