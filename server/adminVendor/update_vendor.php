<?php
session_start();
error_reporting(0);
include("../src/scripts/db/connect.php");

$error = '';
$success = '';

if (isset($_POST['submit'])) {
    if (empty($_POST['c_name']) || empty($_POST['res_name']) || $_POST['email'] == '' || $_POST['phone'] == '' || $_POST['o_hr'] == '' || $_POST['c_hr'] == '' || $_POST['o_days'] == '') {
        $error = '<div class="alert alert-danger">All fields Must be Fillup!</div>';
    } else {
        $fname = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $fsize = $_FILES['file']['size'];
        $extension = explode('.', $fname);
        $extension = strtolower(end($extension));
        $fnew = uniqid() . '.' . $extension;
        $store = "../assets/vendorassets/" . basename($fnew);

        if ($extension == 'jpg' || $extension == 'png' || $extension == 'gif') {
            if ($fsize >= 1000000) {
                $error = '<div class="alert alert-danger">Max Image Size is 1024kb!</div>';
            } else {
                $res_upd = $_GET['res_upd'] ?? '';
                $stmt = $db->prepare("UPDATE vendor SET c_id = :c_id, title = :title, email = :email, phone = :phone, url = :url, o_hr = :o_hr, c_hr = :c_hr, o_days = :o_days, image = :image WHERE rs_id = :rs_id");
                $stmt->execute([
                    ':c_id' => $_POST['c_name'],
                    ':title' => $_POST['res_name'],
                    ':email' => $_POST['email'],
                    ':phone' => $_POST['phone'],
                    ':url' => $_POST['url'] ?? '',
                    ':o_hr' => $_POST['o_hr'],
                    ':c_hr' => $_POST['c_hr'],
                    ':o_days' => $_POST['o_days'],
                    ':image' => $fnew,
                    ':rs_id' => $res_upd
                ]);
                move_uploaded_file($temp, $store);
                $success = '<div class="alert alert-success">Record Updated!</div>';
            }
        } elseif ($extension == '') {
            $error = '<div class="alert alert-danger">Select image</div>';
        } else {
            $error = '<div class="alert alert-danger">Invalid extension! png, jpg, Gif are accepted.</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Update Vendors</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="../admin/icons/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../src/styles/css/tailwind.css">
    <link rel="stylesheet" href="../src/styles/css/navbar.css">
    <link rel="stylesheet" href="../src/styles/css/adminVendor/main.css">
    <link rel="stylesheet" href="../src/styles/css/main.css">
</head>

<body>
    <?php
    $loggedInUser = !empty($_SESSION["user_id"]);
    $loggedInAdmin = !empty($_SESSION["adm_id"]);
    $loggedInVendor = !empty($_SESSION["vendor_user_id"]);
    include("../src/includes/navbar.php");
    ?>

    <div class="container-fluid">
        <?php echo $error . $success; ?>
        <div class="col-lg-12">
            <div class="card card-outline-primary">
                <h4 class="m-b-0">Update My Vendor</h4>
                <div class="card-body">
                    <form action='' method='post' enctype="multipart/form-data">
                        <?php
                        $res_upd = $_GET['res_upd'] ?? '';
                        $stmt = $db->prepare("SELECT * FROM vendor WHERE rs_id = :rs_id");
                        $stmt->execute([':rs_id' => $res_upd]);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <label>Vendor Name</label>
                                <input type="text" name="res_name"
                                    value="<?php echo htmlentities($row['title'] ?? ''); ?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>E-mail</label>
                                <input type="text" name="email" value="<?php echo htmlentities($row['email'] ?? ''); ?>"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <label>Phone</label>
                                <input type="text" name="phone" value="<?php echo htmlentities($row['phone'] ?? ''); ?>"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Open Hours</label>
                                <select name="o_hr" class="form-control">
                                    <option>--Select Hours--</option>
                                    <option value="6am">6am</option>
                                    <option value="7am">7am</option>
                                    <option value="8am">8am</option>
                                    <option value="9am">9am</option>
                                    <option value="10am">10am</option>
                                    <option value="11am">11am</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Close Hours</label>
                                <select name="c_hr" class="form-control">
                                    <option>--Select Hours--</option>
                                    <option value="3pm">3pm</option>
                                    <option value="4pm">4pm</option>
                                    <option value="5pm">5pm</option>
                                    <option value="6pm">6pm</option>
                                    <option value="7pm">7pm</option>
                                    <option value="8pm">8pm</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Open Days</label>
                                <select name="o_days" class="form-control">
                                    <option>--Select Days--</option>
                                    <option value="mon-tue">mon-tue</option>
                                    <option value="mon-wed">mon-wed</option>
                                    <option value="mon-thu">mon-thu</option>
                                    <option value="mon-fri">mon-fri</option>
                                    <option value="mon-sat">mon-sat</option>
                                    <option value="24/7">24/7</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Image</label>
                                <input type="file" name="file" class="form-control">
                                <?php
                                if (!empty($row['image'])) {
                                    $imageFile = $row['image'];
                                    $imagePath = __DIR__ . '/../public/assets/vendorassets/' . $imageFile;
                                    $imageUrl = file_exists($imagePath)
                                        ? '/assets/vendorassets/' . $imageFile
                                        : '/assets/images/logo.png';
                                    echo '<img src="' . $imageUrl . '" style="max-width:100%;">';
                                }
                                ?>
                            </div>
                            <div class="col-md-12">
                                <label>Select Category</label>
                                <select name="c_name" class="form-control">
                                    <option>--Select Category--</option>
                                    <?php
                                    $stmt = $db->query("SELECT * FROM vendor_group");
                                    while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . htmlentities($rows['c_id']) . '">' . htmlentities($rows['c_name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-actions">
                            <input type="submit" name="submit" class="btn btn-primary" value="Save">
                            <a href="index.php" class="btn btn-inverse">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>