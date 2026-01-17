<?php
include("../src/scripts/db/connect.php");

if (empty($_SESSION["adm_id"])) {
    header('location:login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>View Order</title>
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
                    <ul class="navbar-nav mr-auto mt-md-0">
                    </ul>
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
                        <li><a href="index.php"><i class="fa fa-tachometer"></i><span>Dashboard</span></a></li>
                        <li><a href="all_users.php"> <span><i
                                        class="fa fa-user f-s-20 "></i></span><span>Users</span></a></li>
                        <li><a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-cutlery"
                                    aria-hidden="true"></i><span class="hide-menu">Menu</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="new_food.php">Add Menu</a></li>
                                <li><a href="all_menu.php">View All Menus</a></li>
                            </ul>
                        </li>
                        <li><a class="has-arrow  " href="#" aria-expanded="false"><i
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
                <div class="row">
                    <div class="col-12">
                        <div class="col-lg-12">
                            <div class="card card-outline-primary">
                                <div class="card-header">
                                    <h4 class="m-b-0 text-white">View Order</h4>
                                </div>
                                <div class="table-responsive m-t-20">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <tbody>
                                            <?php
                                            $user_upd = isset($_GET['user_upd']) ? $_GET['user_upd'] : '';
                                            $stmt = $db->prepare("SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id WHERE o_id = :o_id");
                                            $stmt->execute([':o_id' => $user_upd]);
                                            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                            <tr>
                                                <td><strong>Username:</strong></td>
                                                <td>
                                                    <center><?php echo htmlentities($rows['username'] ?? ''); ?>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <a href="javascript:void(0);"
                                                            onClick="popUpWindow('update_order.php?form_id=<?php echo htmlentities($rows['o_id'] ?? ''); ?>');"
                                                            title="Update order">
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-refresh"></i> Update
                                                                Status</button></a>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Title:</strong></td>
                                                <td>
                                                    <center><?php echo htmlentities($rows['title'] ?? ''); ?></center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <a href="javascript:void(0);"
                                                            onClick="popUpWindow('userprofile.php?newform_id=<?php echo htmlentities($rows['o_id'] ?? ''); ?>');"
                                                            title="Update order">
                                                            <button type="button" class="btn btn-info"><i
                                                                    class="fa fa-user"></i> View Details</button></a>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Quantity:</strong></td>
                                                <td>
                                                    <center><?php echo htmlentities($rows['quantity'] ?? ''); ?>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Price:</strong></td>
                                                <td>
                                                    <center>₱<?php echo htmlentities($rows['price'] ?? ''); ?></center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Order Type:</strong></td>
                                                <td>
                                                    <center><?php echo htmlentities($rows['order_type'] ?? ''); ?>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Date:</strong></td>
                                                <td>
                                                    <center><?php echo htmlentities($rows['date'] ?? ''); ?></center>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <?php
                                                $status = $rows['status'] ?? '';
                                                if ($status == "" or $status == "NULL") {
                                                    ?>
                                                    <td>
                                                        <center><button type="button" class="btn btn-info"><span
                                                                    class="fa fa-bars" aria-hidden="true"></span>
                                                                Pending</button></center>
                                                    </td>
                                                    <?php
                                                }
                                                if ($status == "in process") { ?>
                                                    <td>
                                                        <center><button type="button" class="btn btn-warning"><span
                                                                    class="fa fa-cog fa-spin" aria-hidden="true"></span> On
                                                                the Way!</button></center>
                                                    </td>
                                                    <?php
                                                }
                                                if ($status == "closed") {
                                                    ?>
                                                    <td>
                                                        <center><button type="button" class="btn btn-primary"><span
                                                                    class="fa fa-check-circle" aria-hidden="true"></span>
                                                                Delivered</button></center>
                                                    </td>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if ($status == "rejected") {
                                                    ?>
                                                    <td>
                                                        <center><button type="button" class="btn btn-danger"> <i
                                                                    class="fa fa-close"></i> Cancelled</button> </center>
                                                    </td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
        const popUpWindow = (URLStr, width, height) => {
            if (window.popUpWin && !window.popUpWin.closed) {
                window.popUpWin.close();
            }
            window.popUpWin = window.open(URLStr, 'popUpWin', `width=1000,height=1000`);
        };

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

            // Custom Dropdown Toggle
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