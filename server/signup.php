<?php
include("src/scripts/db/connect.php");
if (isset($_POST['submit'])) {
    $msg = "";
    $fields = ['firstname', 'lastname', 'email', 'phone', 'password', 'cpassword'];
    $requiredFields = array_filter($fields, function ($field) {
        return empty($_POST[$field]);
    });
    if (!empty($requiredFields)) {
        $msg = "All fields are required!";
    } else {
        $stmt_username = $db->prepare("SELECT username FROM users WHERE username = :username");
        $stmt_username->execute([':username' => $_POST['username']]);

        $stmt_email = $db->prepare("SELECT email FROM users WHERE email = :email");
        $stmt_email->execute([':email' => $_POST['email']]);

        $passwordMismatch = ($_POST['password'] != $_POST['cpassword']);
        $invalidPhoneNumber = !is_numeric($_POST['phone']);
        $invalidEmail = (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        if ($passwordMismatch) {
            $msg = "Password does not match";
        } elseif ($invalidPhoneNumber) {
            $msg = "Invalid phone number!";
        } elseif ($invalidEmail) {
            $msg = "Invalid email address, please enter a valid email!";
        } elseif ($stmt_username->rowCount() > 0) {
            $msg = "Username already exists!";
        } elseif ($stmt_email->rowCount() > 0) {
            $msg = "Email already exists!";
        } else {
            $hashedPassword = md5($_POST['password']);
            $stmt = $db->prepare("INSERT INTO users(username, f_name, l_name, email, phone, password, address) VALUES(:username, :f_name, :l_name, :email, :phone, :password, :address)");
            $stmt->execute([
                ':username' => $_POST['username'],
                ':f_name' => $_POST['firstname'],
                ':l_name' => $_POST['lastname'],
                ':email' => $_POST['email'],
                ':phone' => $_POST['phone'],
                ':password' => $hashedPassword,
                ':address' => $_POST['address'] ?? ''
            ]);
            $msg = "Signup successful! Redirecting to login page...";
            header("refresh:3;url=login.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="icon" href="/assets/images/logo.png">
    <link rel="stylesheet" href="src/styles/css/tailwind.css">
    <link rel="stylesheet" href="src/styles/css/loader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="src/styles/css/signup.css">
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

    <div class="signup-container">
        <div class="form-module">
            <div class="form">
                <h3 class="form-title">Sign Up</h3>
                <?php
                if (stripos($msg, "success") !== false) {
                    echo '<p style="color: green;">' . $msg . '</p>';
                } else {
                    echo '<p style="color: red;">' . $msg . '</p>';
                }
                ?>
                <form action="" method="post">
                    <div>
                        <label>Username</label><input type="text" name="username" id="username"
                            placeholder="Username...">
                    </div>
                    <div class="form-row">
                        <div>
                            <label>First Name</label><input type="text" name="firstname" id="firstname"
                                placeholder="First Name... (eg. Best)">
                        </div>
                        <div>
                            <label>Last Name</label><input type="text" name="lastname" id="lastname"
                                placeholder="Last Name... (eg. Friend)">
                        </div>
                    </div>
                    <div class="form-row">
                        <div>
                            <label>Email Address</label><input type="text" name="email" id="email"
                                placeholder="(eg. example@gmail.com)">
                        </div>
                        <div>
                            <label>Phone Number</label><input type="text" name="phone" id="phone"
                                placeholder="(eg. 09123456789)">
                        </div>
                    </div>
                    <div>
                        <label>Password</label><input type="password" name="password" id="password"
                            placeholder="Password...">
                    </div>
                    <div>
                        <label>Confirm Password</label><input type="password" name="cpassword" id="cpassword"
                            placeholder="Confirm Your Password...">
                    </div>
                    <div class="button">
                        <p><input type="submit" value="SIGNUP" name="submit"></p>
                    </div>
                </form>
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