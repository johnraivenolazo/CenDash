<?php
include("../src/scripts/db/connect.php");
if (empty($_SESSION["adm_id"])) {
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CenDash | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/styles/css/tailwind.css">
    <link href="../src/styles/css/admin.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="fix-header fix-sidebar">
    <div id="main-wrapper">
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">
                        <span><img src="../../public/assets/images/logo.png" alt="logo" class="dark-logo"
                                style="height: 40px;" /></span>
                        CenDash Admin
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0"></ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <!-- Mobile Toggle -->
                            <a class="nav-link nav-toggle text-muted hidden-md-up" href="javascript:void(0)">
                                <i class="fa fa-bars"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted" href="#" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user-circle"
                                    style="font-size: 1.5rem; color: var(--color-primary);"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                    <li><a href="#" onclick="logOutAdmin()"><i class="fa fa-power-off"></i> Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="left-sidebar">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-label">Home</li>
                        <li><a href="index.php" class="active"><i
                                    class="fa fa-tachometer"></i><span>Dashboard</span></a></li>
                        <li class="nav-label">Log</li>
                        <li><a href="all_users.php"> <span><i
                                        class="fa fa-user f-s-20 "></i></span><span>Users</span></a></li>
                        <li><a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-cutlery"
                                    aria-hidden="true"></i><span class="hide-menu">Menu</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="new_food.php">Add Menu</a></li>
                                <li><a href="all_menu.php">View All Menus</a></li>
                            </ul>
                        </li>
                        <li><a class="has-arrow" href="#" aria-expanded="false"><i
                                    class="fa fa-archive f-s-20 color-warning"></i><span
                                    class="hide-menu">Vendors</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="new_vendor.php">Add Vendors</a></li>
                                <li><a href="new_category.php">Add Category</a></li>
                                <li><a href="all_vendors.php">View All Vendors</a></li>
                            </ul>
                        </li>
                        <li><a href="all_orders.php"><i class="fa fa-shopping-cart"
                                    aria-hidden="true"></i><span>Orders</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="card card-outline-primary" style="border: none; box-shadow: none; background: transparent;">
                    <div class="card-header" style="border-bottom: none; padding-left: 0;">
                        <h4 class="m-b-0 text-white" style="font-size: 1.8rem;">Dashboard Overview</h4>
                    </div>
                </div>

                <div class="dashboard-grid">
                    <!-- Vendors -->
                    <div class="card p-30 dashboard-card">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-home f-s-40" style="color: var(--color-primary);"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2>
                                    <?php $stmt = $db->query("SELECT COUNT(*) as count FROM vendor");
                                    echo $stmt->fetch()['count']; ?>
                                </h2>
                                <p class="m-b-0">Vendors</p>
                            </div>
                        </div>
                    </div>

                    <!-- Foods -->
                    <div class="card p-30 dashboard-card">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-cutlery f-s-40" style="color: var(--color-primary);"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2>
                                    <?php $stmt = $db->query("SELECT COUNT(*) as count FROM foods");
                                    echo $stmt->fetch()['count']; ?>
                                </h2>
                                <p class="m-b-0">Foods</p>
                            </div>
                        </div>
                    </div>

                    <!-- Users -->
                    <div class="card p-30 dashboard-card">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-users f-s-40" style="color: var(--color-primary);"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2>
                                    <?php $stmt = $db->query("SELECT COUNT(*) as count FROM users");
                                    echo $stmt->fetch()['count']; ?>
                                </h2>
                                <p class="m-b-0">Users</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Orders -->
                    <div class="card p-30 dashboard-card">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-shopping-cart f-s-40"
                                        style="color: var(--color-primary);"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2>
                                    <?php $stmt = $db->query("SELECT COUNT(*) as count FROM users_orders");
                                    echo $stmt->fetch()['count']; ?>
                                </h2>
                                <p class="m-b-0">Total Orders</p>
                            </div>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="card p-30 dashboard-card">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-th-large f-s-40" style="color: var(--color-primary);"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2>
                                    <?php $stmt = $db->query("SELECT COUNT(*) as count FROM vendor_group");
                                    echo $stmt->fetch()['count']; ?>
                                </h2>
                                <p class="m-b-0">Vendor Categories</p>
                            </div>
                        </div>
                    </div>

                    <!-- Processing Orders -->
                    <div class="card p-30 dashboard-card">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-spinner f-s-40" style="color: #fbbf24;"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2>
                                    <?php
                                    $stmt = $db->prepare("SELECT COUNT(*) as count FROM users_orders WHERE status = :status");
                                    $stmt->execute([':status' => 'in process']);
                                    echo $stmt->fetch()['count'];
                                    ?>
                                </h2>
                                <p class="m-b-0">Processing Orders</p>
                            </div>
                        </div>
                    </div>

                    <!-- Delivered Orders -->
                    <div class="card p-30 dashboard-card">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-check f-s-40" style="color: #34d399;"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2>
                                    <?php
                                    $stmt = $db->prepare("SELECT COUNT(*) as count FROM users_orders WHERE status = :status");
                                    $stmt->execute([':status' => 'closed']);
                                    echo $stmt->fetch()['count'];
                                    ?>
                                </h2>
                                <p class="m-b-0">Delivered Orders</p>
                            </div>
                        </div>
                    </div>

                    <!-- Cancelled Orders -->
                    <div class="card p-30 dashboard-card">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fa fa-times f-s-40" style="color: #f87171;"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2>
                                    <?php
                                    $stmt = $db->prepare("SELECT COUNT(*) as count FROM users_orders WHERE status = :status");
                                    $stmt->execute([':status' => 'rejected']);
                                    echo $stmt->fetch()['count'];
                                    ?>
                                </h2>
                                <p class="m-b-0">Cancelled Orders</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script>var APP_ROOT = "../";</script>
    <script src="../src/scripts/userAction/userAction.js"></script>
    <script>
        // Sidebar & Dropdown Toggle Script
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.querySelector('.nav-toggle');
            const sidebar = document.querySelector('.left-sidebar');
            const pageWrapper = document.querySelector('.page-wrapper');
            if (toggle) {
                toggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (sidebar) sidebar.classList.toggle('active');
                    if (pageWrapper) pageWrapper.classList.toggle('active');
                });
            }

            // Custom Dropdown Toggle (replaces Bootstrap if broken)
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            dropdownToggles.forEach(dt => {
                dt.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const menu = this.nextElementSibling;
                    if (menu && menu.classList.contains('dropdown-menu')) {
                        menu.classList.toggle('show');
                    }
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                        menu.classList.remove('show');
                    });
                }
            });
        });
    </script>
</body>

</html>