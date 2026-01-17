<?php
session_start();
error_reporting(0);
include("../src/scripts/db/connect.php");

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = ['username', 'f_name', 'l_name', 'email', 'phone', 'password', 'vendor'];
    $requiredFields = array_filter($fields, function ($field) {
        return empty($_POST[$field]);
    });

    if (!empty($requiredFields)) {
        $msg = "All fields are required!";
    } else {
        // Check username using prepared statement
        $stmt = $db->prepare("SELECT username FROM vendor_users WHERE username = :username");
        $stmt->execute([':username' => $_POST['username']]);
        $usernameExists = $stmt->rowCount() > 0;

        // Check email using prepared statement
        $stmt = $db->prepare("SELECT email FROM vendor_users WHERE email = :email");
        $stmt->execute([':email' => $_POST['email']]);
        $emailExists = $stmt->rowCount() > 0;

        $passwordMismatch = ($_POST['password'] != $_POST['cpassword']);
        $invalidPhoneNumber = !is_numeric($_POST['phone']);
        $invalidEmail = (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));

        if ($passwordMismatch) {
            $msg = "Password does not match";
        } elseif ($invalidPhoneNumber) {
            $msg = "Invalid phone number!";
        } elseif ($invalidEmail) {
            $msg = "Invalid email address, please enter a valid email!";
        } elseif ($usernameExists) {
            $msg = "Username already exists!";
        } elseif ($emailExists) {
            $msg = "Email already exists!";
        } else {
            $hashedPassword = md5($_POST['password']);

            // Use prepared statement for insert
            $stmt = $db->prepare("INSERT INTO vendor_users (username, f_name, l_name, email, phone, password, rs_id) 
                    VALUES (:username, :f_name, :l_name, :email, :phone, :password, :rs_id)");

            try {
                $stmt->execute([
                    ':username' => $_POST['username'],
                    ':f_name' => $_POST['f_name'],
                    ':l_name' => $_POST['l_name'],
                    ':email' => $_POST['email'],
                    ':phone' => $_POST['phone'],
                    ':password' => $hashedPassword,
                    ':rs_id' => $_POST['vendor']
                ]);
                $msg = "Signup successful! Redirecting to login page...";
                header("refresh:3;url=signin.php");
            } catch (PDOException $e) {
                $msg = "Error: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Signup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="../src/styles/css/tailwind.css">
    <link rel="stylesheet" href="../src/styles/css/signup.css">
    <link rel="stylesheet" href="../src/styles/css/main.css">
    <link rel="stylesheet" href="../admin/icons/font-awesome/css/font-awesome.min.css">
</head>

<body>
    <!-- Navbar -->
    <?php
    $loggedInUser = !empty($_SESSION["user_id"]);
    $loggedInAdmin = !empty($_SESSION["adm_id"]);
    $loggedInVendor = !empty($_SESSION["vendor_user_id"]);
    include("../src/includes/navbar.php");
    ?>

    <div class="signup-container">
        <div class="form-module">
            <div class="form">
                <h3 class="form-title">Sign Up</h3>
                <div class="popup">
                    <?php if (stripos($msg, "success") !== false): ?>
                        <span class="success"><?php echo $msg; ?></span>
                    <?php elseif (!empty($msg)): ?>
                        <span class="error"><?php echo $msg; ?></span>
                    <?php endif; ?>
                </div>

                <form action="" method="post">
                    <div class="form-row">
                        <div>
                            <label>Username</label>
                            <input type="text" name="username" placeholder="Username" required>
                        </div>
                        <div>
                            <label>Email</label>
                            <input type="email" name="email" placeholder="Email" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div>
                            <label>First Name</label>
                            <input type="text" name="f_name" placeholder="First Name" required>
                        </div>
                        <div>
                            <label>Last Name</label>
                            <input type="text" name="l_name" placeholder="Last Name" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div>
                            <label>Phone</label>
                            <input type="tel" name="phone" placeholder="Phone Number" required>
                        </div>
                        <div>
                            <label>Select Vendor</label>
                            <select name="vendor" class="form-control"
                                style="background: var(--bg-primary); border: 1px solid var(--border-color); color: var(--text-primary); padding: 0.8rem 1rem; border-radius: var(--radius-md); width: 100%; margin-bottom: 1.5rem;"
                                required>
                                <?php
                                $stmt = $db->query("SELECT rs_id, title FROM vendor");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . htmlentities($row['rs_id']) . "'>" . htmlentities($row['title']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div>
                            <label>Password</label>
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                        <div>
                            <label>Confirm Password</label>
                            <input type="password" name="cpassword" placeholder="Confirm Password" required>
                        </div>
                    </div>

                    <input type="submit" name="submit" value="Sign Up" class="w-full">
                </form>
            </div>
            <div class="cta">
                <p>Already have an account?</p>
                <a href="signin.php"> Login here</a>
            </div>
        </div>
    </div>

    <script src="../src/scripts/userAction/userAction.js"></script>
    <script src="../src/scripts/main.js"></script>
</body>

</html>