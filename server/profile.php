<?php
include("src/scripts/db/connect.php");
if (empty($_SESSION["user_id"])) {
    header('location:login.php');
    exit;
}
if ($_SESSION["user_id"] != $_GET['user_upd']) {
    echo "<script>alert(\"You are not allowed to view other user's info.\");</script>";
    echo "<script>window.location.href='index.php';</script>";
}
if (isset($_POST['submit'])) {
    if (empty($_POST['uname']) || empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['email']) || empty($_POST['phone'])) {
        $error = '<div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                <strong>All fields Required!</strong>
              </div>';
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <strong>Invalid email!</strong>
                        </div>';
        } elseif (strlen($_POST['password']) == 0) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <strong>Please type your new password!</strong>
                        </div>';
        } elseif (strlen($_POST['password']) < 6) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <strong>Password must be greater or equal than 6 characters!</strong>
                        </div>';
        } elseif (strlen($_POST['phone']) < 10) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <strong>Invalid phone!</strong>
                        </div>';
        } else {
            $hashedPassword = md5($_POST['password']);

            $stmt = $db->prepare("UPDATE users SET username = :username, f_name = :f_name, l_name = :l_name, email = :email, phone = :phone, password = :password WHERE u_id = :u_id");
            $stmt->execute([
                ':username' => $_POST['uname'],
                ':f_name' => $_POST['fname'],
                ':l_name' => $_POST['lname'],
                ':email' => $_POST['email'],
                ':phone' => $_POST['phone'],
                ':password' => $hashedPassword,
                ':u_id' => intval($_GET['user_upd'])
            ]);

            $success = '<div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>User Updated!</strong>
                        </div>';
        }
    }
}

$user_id = isset($_GET['user_upd']) ? intval($_GET['user_upd']) : 0;
$stmt = $db->prepare("SELECT * FROM users WHERE u_id = :u_id");
$stmt->execute([':u_id' => $user_id]);
$newrow = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CenDash | My Profile</title>
    <link rel="stylesheet" href="src/styles/css/tailwind.css">
    <link rel="stylesheet" href="src/styles/css/loader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous">
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
    <div class="myprofile">
        <form action='' method='post' class="myprofile-form">
            <?php
            echo $error;
            echo $success;
            ?>
            <h1 class="title">My Profile</h1>
            <div class="form-body">
                <div class="form-group">
                    <label class="form-title">Username</label>
                    <input type="text" name="uname" value="<?php echo $newrow['username']; ?>">
                </div>
                <div class="form-group">
                    <label class="form-title">First Name</label>
                    <input type="text" name="fname" value="<?php echo $newrow['f_name']; ?>">
                </div>
                <div class="form-group">
                    <label class="form-title">Last Name</label>
                    <input type="text" name="lname" value="<?php echo $newrow['l_name']; ?>">
                </div>
                <div class="form-group">
                    <label class="form-title">Email</label>
                    <input type="text" name="email" value="<?php echo $newrow['email']; ?>">
                </div>
                <div class="form-group">
                    <label class="form-title">Password</label>
                    <input type="password" name="password" placeholder="Type your new password...">
                </div>
                <div class="form-group">
                    <label class="form-title">Phone</label>
                    <input type="text" name="phone" value="<?php echo $newrow['phone']; ?>">
                </div>
            </div>
            <div class="form-actions">
                <input type="submit" name="submit" class="btn" value="Save">
                <a href="." class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-cta">
                <h3>Join Us</h3>
                <p>Join other vendors who benefit from having partnered with us.</p>
            </div>
            <div class="footer-copyright">
                <p><a href="../"><b>&copy; 2026</b>, <b>CenDash</b>.</a> All rights reserved.</p>
            </div>
        </div>
    </footer>


    <script src="src/scripts/userAction/userAction.js"></script>
    <script src="src/scripts/main.js"></script>
</body>

</html>