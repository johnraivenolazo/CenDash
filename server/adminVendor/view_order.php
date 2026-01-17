<?php
include("../src/scripts/db/connect.php");

if (empty($_SESSION["vendor_user_id"])) {
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="../admin/icons/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../src/styles/css/tailwind.css">
    <link rel="stylesheet" href="../src/styles/css/navbar.css">
    <link rel="stylesheet" href="../src/styles/css/adminVendor/main.css">
    <link rel="stylesheet" href="../src/styles/css/main.css">
    <script>
        var popUpWin = 0;
        function popUpWindow(URLStr, left, top, width, height) {
            if (popUpWin) { if (!popUpWin.closed) popUpWin.close(); }
            popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=1000,height=1000,left=' + left + ',top=' + top);
        }
    </script>
</head>
<body>
    <?php
    $loggedInUser = !empty($_SESSION["user_id"]);
    $loggedInAdmin = !empty($_SESSION["adm_id"]);
    $loggedInVendor = !empty($_SESSION["vendor_user_id"]);
    include("../src/includes/navbar.php");
    ?>

    <div id="main-wrapper">
        <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="col-lg-12">
                            <div class="card card-outline-primary">
                                <div class="card-header"><h4 class="m-b-0 text-white">View Order</h4></div>
                                <div class="table-responsive m-t-20">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <tbody>
                                            <?php
                                            $user_upd = $_GET['user_upd'] ?? '';
                                            $stmt = $db->prepare("SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id WHERE o_id = :o_id");
                                            $stmt->execute([':o_id' => $user_upd]);
                                            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                            <tr>
                                                <td><strong>Username:</strong></td>
                                                <td><center><?php echo htmlentities($rows['username'] ?? ''); ?></center></td>
                                                <td><center><a href="javascript:void(0);" onClick="popUpWindow('update_order.php?form_id=<?php echo htmlentities($rows['o_id'] ?? ''); ?>');"><button type="button" class="btn btn-primary">Update Order Status</button></a></center></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Title:</strong></td>
                                                <td><center><?php echo htmlentities($rows['title'] ?? ''); ?></center></td>
                                                <td><center><a href="javascript:void(0);" onClick="popUpWindow('userprofile.php?newform_id=<?php echo htmlentities($rows['o_id'] ?? ''); ?>');"><button type="button" class="btn btn-primary">View User Details</button></a></center></td>
                                            </tr>
                                            <tr><td><strong>Quantity:</strong></td><td><center><?php echo htmlentities($rows['quantity'] ?? ''); ?></center></td></tr>
                                            <tr><td><strong>Price:</strong></td><td><center>₱<?php echo htmlentities($rows['price'] ?? ''); ?></center></td></tr>
                                            <tr><td><strong>Order Type:</strong></td><td><center><?php echo htmlentities($rows['order_type'] ?? ''); ?></center></td></tr>
                                            <tr><td><strong>Date:</strong></td><td><center><?php echo htmlentities($rows['date'] ?? ''); ?></center></td></tr>
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <?php $status = $rows['status'] ?? '';
                                                if ($status == "" || $status == "NULL") { ?>
                                                    <td><center><button type="button" class="btn btn-info"><span class="fa fa-bars"></span> Pending</button></center></td>
                                                <?php } if ($status == "in process") { ?>
                                                    <td><center><button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin"></span>On the Way!</button></center></td>
                                                <?php } if ($status == "closed") { ?>
                                                    <td><center><button type="button" class="btn btn-primary"><span class="fa fa-check-circle"></span> Delivered</button></center></td>
                                                <?php } if ($status == "rejected") { ?>
                                                    <td><center><button type="button" class="btn btn-danger"><i class="fa fa-close"></i> Cancelled</button></center></td>
                                                <?php } ?>
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
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="../src/scripts/userAction/userAction.js"></script>
</body>
</html>