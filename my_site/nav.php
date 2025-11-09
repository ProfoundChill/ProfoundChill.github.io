<?php
// Get the current file name to highlight the active page
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav id="my-nav">
    <a href="javascript:void(0);" class="icon" onclick="toggleMenu()">
        <i class="fa fa-bars"></i> 
    </a>
    
    <a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'current-page' : ''; ?> logo-link">
        <img src="images/logo.webp" alt="ProfoundChill Logo" class="nav-logo">
    </a>

    <div class="dropdown">
        <button class="dropbtn" **onclick="toggleDropdown()"**>
            Discover me! &#9660;
        </button> 
        <div class="dropdown-content" **id="discoverDropdown"**>
            <a href="my_vacation.php" class="<?php echo ($current_page == 'my_vacation.php') ? 'current-page' : ''; ?>">My Dream Vacation</a> 
            <a href="my_artistic_self.php" class="<?php echo ($current_page == 'my_artistic_self.php') ? 'current-page' : ''; ?>">My Artistic Self</a>
        </div>
    </div>
    
    <a href="marketplace.php" class="<?php echo ($current_page == 'marketplace.php') ? 'current-page' : ''; ?>">Marketplace</a> 
    <a href="my_form.php" class="<?php echo ($current_page == 'my_form.php') ? 'current-page' : ''; ?>">My Quiz Form</a> 
    <a href="login.php" class="<?php echo ($current_page == 'login.php' || $current_page == 'to-do.php') ? 'current-page' : ''; ?>">To-Do List</a>

</nav>