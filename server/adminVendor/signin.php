<?php
session_start();
error_reporting(0);
include("../src/scripts/db/connect.php");

if (!empty($_SESSION['vendor_user_id'])) {
    echo "<script>alert('You are already logged in.');</script>";
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

$message = $success = "";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($_POST["submit"])) {
        // Use prepared statement for login query
        $stmt = $db->prepare("SELECT * FROM vendor_users WHERE username = :username AND password = :password");
        $stmt->execute([':username' => $username, ':password' => md5($password)]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $_SESSION["vendor_user_id"] = $row['vu_id'];
            $success = "Success! Vendor user logged in.";
            header("refresh:2;url=index.php");
        } else {
            $message = "Invalid Username or Password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Vendor Login</title>
    <link rel="icon" href="../assets/images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="../src/styles/css/tailwind.css">
    <link rel="stylesheet" href="../src/styles/css/login.css">
    <link rel="stylesheet" href="../src/styles/css/footer.css">
    <link rel="stylesheet" href="../src/styles/css/navbar.css">
    <link rel="stylesheet" href="../src/styles/css/main.css">
</head>

<body>
    <?php
    $loggedInUser = !empty($_SESSION["user_id"]);
    $loggedInAdmin = !empty($_SESSION["adm_id"]);
    $loggedInVendor = !empty($_SESSION["vendor_user_id"]);
    include("../src/includes/navbar.php");
    ?>


    <div class="login-content">
        <div class="form-module">
            <div class="form">
                <h3 class="form-title">Login</h3>
                <div class="popup">
                    <span class="error"><?php echo $message; ?></span>
                    <span class="success"><?php echo $success; ?></span>
                </div>
                <form action="" method="post">
                    <label>Username</label><input type="text" placeholder="Username..." name="username" />
                    <label>Password</label><input type="password" placeholder="Password..." name="password" />
                    <input type="submit" id="buttn" value="LOGIN" name="submit" />
                </form>
            </div>
            <div class="cta">
                <p>Not a member yet?</p>
                <a href=".">Contact Dev</a>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div>
                <h3>Join Us</h3>
                <p>Join other vendors who benefit from having partnered with us.</p>
            </div>
            <div>
                <p><b>&copy; 2023</b>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="../src/scripts/nav.js"></script>
    <script src="../src/scripts/vendorUserAction/vendorUserAction.js"></script>
</body>

</html>