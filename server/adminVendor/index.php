<?php
include("../src/scripts/db/connect.php");

if (empty($_SESSION['vendor_user_id'])) {
    header('location:signin.php');
} else {
    $vendorId = $_SESSION['vendor_user_id'];

    if (isset($_GET['order_del'])) {
        $orderId = $_GET['order_del'];
        // Use prepared statement for delete
        $stmt = $db->prepare("DELETE FROM users_orders WHERE o_id = :o_id");
        $stmt->execute([':o_id' => $orderId]);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CenDash | Admin Vendors</title>
    <link rel="icon" href="../assets/images/logo.png">
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


    <div class="card">
        <table>
            <caption class="card-header">My Vendor</caption>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Operating Hours</th>
                    <th>Open Days</th>
                    <th>Image</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Use prepared statement for vendor query
                $stmt = $db->prepare("SELECT r.*, rc.c_name FROM vendor r 
                            JOIN vendor_group rc ON r.c_id = rc.c_id
                            WHERE r.rs_id = :rs_id 
                            ORDER BY r.rs_id DESC");
                $stmt->execute([':rs_id' => $vendorId]);

                if ($stmt->rowCount() == 0) {
                    echo '<td colspan="11">No Vendors</td>';
                } else {
                    while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $imageFile = $rows['image'] ?? '';
                        $imagePath = __DIR__ . '/../public/assets/vendorassets/' . $imageFile;
                        $imageUrl = (!empty($imageFile) && file_exists($imagePath))
                            ? '/assets/vendorassets/' . $imageFile
                            : '/assets/images/logo.png';

                        echo ' 
                    <tr>
                    <td>' . htmlentities($rows['title']) . '</td>
                    <td>' . htmlentities($rows['c_name']) . '</td>
                    <td>' . htmlentities($rows['email']) . '</td>
                    <td>' . htmlentities($rows['phone']) . '</td>
                    <td>' . htmlentities($rows['o_hr']) . '</td>
                    <td>' . htmlentities($rows['o_days']) . '</td>	
                    <td>
                        <div>
                            <img src="' . $imageUrl . '"/>
                        </div>
                    </td>
                    <td>' . htmlentities($rows['date']) . '</td>
                    <td>
                        <a href="update_vendor.php?res_upd=' . htmlentities($rows['rs_id']) . '" class="btn">
                            <i class="fa fa-edit">EDIT</i>
                        </a>
                    </td>
                    </tr>
                    ';
                    }
                }
                ?>
            </tbody>
        </table>

    </div>
    <div id="main-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="col-lg-12">
                        <div class="card card-outline-primary">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">My Customer Order</h4>
                            </div>
                            <div class="table-responsive m-t-40">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>User</th>
                                            <th>Food</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Reg-Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Use prepared statement for orders query
                                        $stmt = $db->prepare("SELECT users.*, users_orders.* FROM users 
                                            JOIN users_orders ON users.u_id=users_orders.u_id 
                                            WHERE users_orders.rs_id = :rs_id");
                                        $stmt->execute([':rs_id' => $vendorId]);

                                        if ($stmt->rowCount() == 0) {
                                            echo '<td colspan="8"><center>No Orders</center></td>';
                                        } else {
                                            while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                <?php
                                                echo ' <tr>
													<td>' . htmlentities($rows['username']) . '</td>
													<td>' . htmlentities($rows['title']) . '</td>
													<td>' . htmlentities($rows['quantity']) . '</td>
													<td>₱' . htmlentities($rows['price']) . '</td>';
                                                ?>
                                                <?php
                                                $status = $rows['status'] ?? '';
                                                if ($status == "" or $status == "NULL") {
                                                    ?>
                                                    <td> <button type="button" class="btn btn-info"><span class="fa fa-bars"
                                                                aria-hidden="true"></span> Pending</button></td>
                                                    <?php
                                                }
                                                if ($status == "in process") { ?>
                                                    <td> <button type="button" class="btn btn-warning"><span
                                                                class="fa fa-cog fa-spin" aria-hidden="true"></span> On The
                                                            Way!</button></td>
                                                    <?php
                                                }
                                                if ($status == "closed") {
                                                    ?>
                                                    <td> <button type="button" class="btn btn-primary"><span
                                                                class="fa fa-check-circle" aria-hidden="true"></span>
                                                            Delivered</button></td>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if ($status == "rejected") {
                                                    ?>
                                                    <td> <button type="button" class="btn btn-danger"> <i class="fa fa-close"></i>
                                                            Cancelled</button></td>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                echo '	<td>' . htmlentities($rows['date']) . '</td>';
                                                ?>
                                                <td>
                                                    <a href="?order_del=<?php echo htmlentities($rows['o_id']); ?>"
                                                        onclick="return confirm('Are you sure?');"
                                                        class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i
                                                            class="fa fa-trash" style="font-size:16px"></i>TRASH</a>
                                                    <?php
                                                    echo '<a href="../admin/view_order.php?user_upd=' . htmlentities($rows['o_id']) . '" class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="fa fa-edit"></i>EDIT</a>
																	</td>
																	</tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>var APP_ROOT = "../";</script>
    <script src="../src/scripts/userAction/userAction.js"></script>
    <script src="../src/scripts/main.js"></script>
</body>

</html>