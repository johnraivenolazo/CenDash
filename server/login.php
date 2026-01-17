<?php
include("src/scripts/db/connect.php");

if (!empty($_SESSION['user_id'])) {
    echo "<script>alert('You are already logged in.');</script>";
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($_POST["submit"])) {
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->execute([
            ':username' => $username,
            ':password' => md5($password)
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (is_array($row)) {
            $_SESSION["user_id"] = $row['u_id'];
            $success = "Success! User logged in.";
            header("refresh:1.5;url=.");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="/assets/images/logo.png">
    <link rel="stylesheet" href="src/styles/css/tailwind.css">
    <link rel="stylesheet" href="src/styles/css/loader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="src/styles/css/login.css">
    <link rel="stylesheet" href="src/styles/css/footer.css">
    <link rel="stylesheet" href="src/styles/css/navbar.css">
    <link rel="stylesheet" href="src/styles/css/main.css">
</head>

<body>
    <div class="loader">
        <h1 class="loader-title">Now Loading...</h1>
        <div class="cooking">
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div id=area>
                <div id="sides">
                    <div id="pan"></div>
                    <div id="handle"></div>
                </div>
                <div id="pancake">
                    <div id="pastry"></div>
                </div>
            </div>
        </div>
    </div>

    <?php include("src/includes/navbar.php"); ?>

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
                <p>Not registered yet?</p>
                <a href="signup.php"> Create an account</a>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-cta">
                <h3>Join Us</h3>
                <p>Join other vendors who benefit from having partnered with us.</p>
            </div>
            <div class="footer-copyright">
                <p><a href="../"><b>&copy; 2026</b>.</a> All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="src/scripts/userAction/userAction.js"></script>
    <script src="src/scripts/main.js"></script>
</body>

</html>