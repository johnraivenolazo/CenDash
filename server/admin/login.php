<?php
include("../src/scripts/db/connect.php");

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($_POST["submit"])) {
        $stmt = $db->prepare("SELECT * FROM admin WHERE username = :username AND password = :password");
        $stmt->execute([
            ':username' => $username,
            ':password' => md5($password)
        ]);
        $row = $stmt->fetch();

        if ($row) {
            $_SESSION["adm_id"] = $row['adm_id'];
            $success = "Login successful!";
            header("refresh:2;url=index.php");
        } else {
            $error = "Invalid Username or Password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="icon" href="../assets/images/logo.png">
    <link rel="stylesheet" href="../src/styles/css/tailwind.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="../admin/icons/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../src/styles/css/login.css">
    <link rel="stylesheet" href="../src/styles/css/navbar.css">
    <link rel="stylesheet" href="../src/styles/css/main.css">
    <style>
        /* Admin specific adjustments */
        .login-content {
            padding-top: clamp(110px, 16vh, 160px) !important;
        }
    </style>
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
                    <span class="success"
                        style="color: #4ade80; display: block; margin-bottom: 10px;"><?php echo $success ?? ''; ?></span>
                    <span class="error"
                        style="color: #f87171; display: block; margin-bottom: 10px;"><?php echo $error ?? ''; ?></span>
                </div>
                <form class="login-form" action="login.php" method="post">
                    <label>Username</label>
                    <input type="text" placeholder="Username" name="username" />
                    <label>Password</label>
                    <input type="password" placeholder="Password" name="password" />
                    <input type="submit" name="submit" value="Login" />
                </form>
            </div>
            <div class="cta">
                <p>Not an Admin?</p>
                <a href="../login.php"> Go to User Login</a>
            </div>
        </div>
    </div>
</body>

</html>