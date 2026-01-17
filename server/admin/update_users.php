<?php
include("../src/scripts/db/connect.php");

if (empty($_SESSION["adm_id"])) {
    header('location:login.php');
    exit;
}

$error = '';
$success = '';

if (isset($_POST['submit'])) {
    if (
        empty($_POST['uname']) ||
        empty($_POST['fname']) ||
        empty($_POST['lname']) ||
        empty($_POST['email']) ||
        empty($_POST['phone'])
    ) {
        $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>All fields Required!</strong>
                    </div>';
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Invalid email!</strong>
                        </div>';
        } elseif (strlen($_POST['password']) < 6) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Password must be >=6!</strong>
                        </div>';
        } elseif (strlen($_POST['phone']) < 10) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Invalid phone!</strong>
                        </div>';
        } else {
            $hashedPassword = md5($_POST['password']);
            $user_upd = $_GET['user_upd'] ?? '';

            // Use prepared statement for update
            $stmt = $db->prepare("UPDATE users SET 
                        username = :username, 
                        f_name = :f_name, 
                        l_name = :l_name, 
                        email = :email, 
                        phone = :phone, 
                        password = :password 
                    WHERE u_id = :u_id");
            $stmt->execute([
                ':username' => $_POST['uname'],
                ':f_name' => $_POST['fname'],
                ':l_name' => $_POST['lname'],
                ':email' => $_POST['email'],
                ':phone' => $_POST['phone'],
                ':password' => $hashedPassword,
                ':u_id' => $user_upd
            ]);

            $success = '<div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>User Updated!</strong>
                        </div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Users</title>
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
        <div class="left-sidebar active">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-label">Home</li>
                        <li> <a href="index.php"><i class="fa fa-tachometer"></i><span>Dashboard</span></a></li>
                        <li class="nav-label">Log</li>
                        <li> <a href="all_users.php"> <span><i
                                        class="fa fa-user f-s-20 "></i></span><span>Users</span></a></li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i
                                    class="fa fa-archive f-s-20 color-warning"></i><span
                                    class="hide-menu">Vendor</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="all_vendors.php">All Vendors</a></li>
                                <li><a href="new_category.php">Add Category</a></li>
                                <li><a href="new_vendor.php">Add Vendor</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-cutlery"
                                    aria-hidden="true"></i><span class="hide-menu">Menu</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="all_menu.php">All Menues</a></li>
                                <li><a href="new_food.php">Add Menu</a></li>
                            </ul>
                        </li>
                        <li> <a href="all_orders.php"><i class="fa fa-shopping-cart"
                                    aria-hidden="true"></i><span>Orders</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Dashboard</h3>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="container-fluid">
                    <?php
                    echo $error;
                    echo $success;
                    ?>
                    <div class="col-lg-12">
                        <div class="card card-outline-primary">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Update Users</h4>
                            </div>
                            <div class="card-body">
                                <?php
                                $user_upd = $_GET['user_upd'] ?? '';
                                $stmt = $db->prepare("SELECT * FROM users WHERE u_id = :u_id");
                                $stmt->execute([':u_id' => $user_upd]);
                                $newrow = $stmt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <form action='' method='post'>
                                    <div class="form-body">

                                        <hr>
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Username</label>
                                                    <input type="text" name="uname" class="form-control"
                                                        value="<?php echo htmlentities($newrow['username'] ?? ''); ?>"
                                                        placeholder="username">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">First-Name</label>
                                                    <input type="text" name="fname"
                                                        class="form-control form-control-danger"
                                                        value="<?php echo htmlentities($newrow['f_name'] ?? ''); ?>"
                                                        placeholder="jon">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Last-Name </label>
                                                    <input type="text" name="lname" class="form-control"
                                                        placeholder="doe"
                                                        value="<?php echo htmlentities($newrow['l_name'] ?? ''); ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Email</label>
                                                    <input type="text" name="email"
                                                        class="form-control form-control-danger"
                                                        value="<?php echo htmlentities($newrow['email'] ?? ''); ?>"
                                                        placeholder="example@gmail.com">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Password</label>
                                                    <input type="text" name="password"
                                                        class="form-control form-control-danger"
                                                        value="<?php echo htmlentities($newrow['password'] ?? ''); ?>"
                                                        placeholder="password">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Phone</label>
                                                    <input type="text" name="phone"
                                                        class="form-control form-control-danger"
                                                        value="<?php echo htmlentities($newrow['phone'] ?? ''); ?>"
                                                        placeholder="phone">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-check"></i>
                                    Save</button>
                                <a href="all_users.php" class="btn btn-inverse"><i class="fa fa-times"></i> Cancel</a>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <footer class="footer"> © 2023, Cendash. All Rights reserved.</footer>
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