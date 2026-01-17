<?php
$loggedInUser = !empty($_SESSION["user_id"]);
$loggedInAdmin = !empty($_SESSION["adm_id"]);
$loggedInVendor = !empty($_SESSION["vendor_user_id"]);

// Define the root path (adjust if components are deeper)
$root = (basename(getcwd()) == 'admin' || basename(getcwd()) == 'adminVendor') ? '../' : '';
?>
<script>
    var APP_ROOT = "<?= $root ?>";
</script>

<nav class="nav" id="nav">
    <div class="nav-container">
        <!-- Left: Logo -->
        <div class="nav-title">
            <a href="<?= $root ?>.">
                <img src="/assets/images/logo.png">
                <h1>CenDash</h1>
            </a>
        </div>

        <!-- Center: Vendors and Login (Mobile shows all in dropdown) -->
        <div class="nav-center">
            <nav style="width: 100%; display: flex; flex-direction: column; align-items: center;">
                <ul class="nav-list">
                    <li><a href="<?= $root ?>."><i class="fa fa-home"></i>Home</a></li>
                    <li><a href="<?= $root ?>vendors.php"><i class="fa fa-store"></i>Vendors</a></li>
                    <?php if ($loggedInUser): ?>
                        <li><a href="<?= $root ?>orders.php"><i class="fa fa-cart-shopping"></i>My Orders</a></li>
                    <?php endif; ?>

                    <!-- Login Menu with Nested Options (Mobile Only) -->
                    <?php if (!$loggedInUser && !$loggedInAdmin && !$loggedInVendor): ?>
                        <li class="nav-mobile-only has-submenu">
                            <a href="#" class="submenu-toggle"><i class="fa-solid fa-right-to-bracket"></i>Login<i
                                    class="fa-solid fa-chevron-down submenu-arrow"></i></a>
                            <ul class="nav-submenu">
                                <li><a href="<?= $root ?>login.php"><i class="fa-solid fa-user"></i>User Login</a></li>
                                <li><a href="<?= $root ?>admin/"><i class="fa-solid fa-user-shield"></i>Admin Login</a></li>
                                <li><a href="<?= $root ?>adminVendor/"><i class="fa-solid fa-store"></i>Vendor Login</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Sign Up (Mobile Only) -->
                        <li class="nav-mobile-only">
                            <a href="<?= $root ?>signup.php"><i class="fa-solid fa-user-plus"></i>Sign Up</a>
                        </li>
                    <?php else: ?>
                        <!-- Account Options (Mobile Only) -->
                        <li class="nav-mobile-only has-submenu">
                            <a href="#" class="submenu-toggle"><i class="fa-solid fa-user"></i>Account<i
                                    class="fa-solid fa-chevron-down submenu-arrow"></i></a>
                            <ul class="nav-submenu">
                                <?php if ($loggedInUser): ?>
                                    <li><a href="<?= $root ?>profile.php?user_upd=<?= $_SESSION['user_id'] ?>"><i
                                                class="fa-solid fa-id-card"></i>Profile</a></li>
                                    <li><a href="#" onclick="logOutUser()"><i class="fa-solid fa-right-from-bracket"></i>Logout
                                            User</a></li>
                                <?php endif; ?>
                                <?php if ($loggedInAdmin): ?>
                                    <li><a href="<?= $root ?>admin/"><i class="fa-solid fa-gauge"></i>Admin Panel</a></li>
                                    <li><a href="#" onclick="logOutAdmin()"><i class="fa-solid fa-right-from-bracket"></i>Logout
                                            Admin</a></li>
                                <?php endif; ?>
                                <?php if ($loggedInVendor): ?>
                                    <li><a href="<?= $root ?>adminVendor/"><i class="fa-solid fa-building-user"></i>Vendor
                                            Panel</a></li>
                                    <li><a href="#" onclick="logOutVendor()"><i
                                                class="fa-solid fa-right-from-bracket"></i>Logout Vendor</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        <!-- Right: Login/Account (Desktop Only) -->
        <div class="nav-right nav-desktop-only">
            <ul class="nav-list">
                <?php if (!$loggedInUser && !$loggedInAdmin && !$loggedInVendor): ?>
                    <li><a href="#" class="nav-button">Login</a>
                        <ul class="nav-dropdown">
                            <li><a href="<?= $root ?>login.php"><i class="fa-solid fa-user"></i>User Login</a></li>
                            <li><a href="<?= $root ?>admin/"><i class="fa-solid fa-user-shield"></i>Admin Login</a></li>
                            <li><a href="<?= $root ?>adminVendor/"><i class="fa-solid fa-store"></i>Vendor Login</a></li>
                            <li><a href="<?= $root ?>signup.php"><i class="fa-solid fa-user-plus"></i>Sign Up</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><a href="#" class="nav-button">Account</a>
                        <ul class="nav-dropdown">
                            <?php if ($loggedInUser): ?>
                                <li><a href="<?= $root ?>profile.php?user_upd=<?= $_SESSION['user_id'] ?>"><i
                                            class="fa-solid fa-id-card"></i>Profile</a></li>
                                <li><a href="#" onclick="logOutUser()"><i class="fa-solid fa-right-from-bracket"></i>Logout
                                        User</a></li>
                            <?php endif; ?>
                            <?php if ($loggedInAdmin): ?>
                                <li><a href="<?= $root ?>admin/"><i class="fa-solid fa-gauge"></i>Admin Panel</a></li>
                                <li><a href="#" onclick="logOutAdmin()"><i class="fa-solid fa-right-from-bracket"></i>Logout
                                        Admin</a></li>
                            <?php endif; ?>
                            <?php if ($loggedInVendor): ?>
                                <li><a href="<?= $root ?>adminVendor/"><i class="fa-solid fa-building-user"></i>Vendor Panel</a>
                                </li>
                                <li><a href="#" onclick="logOutVendor()"><i class="fa-solid fa-right-from-bracket"></i>Logout
                                        Vendor</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Mobile Hamburger (Always Visible) -->
        <div class="nav-mobile"><a id="nav-toggle"><span></span></a></div>
    </div>
</nav>