<?php
include("src/scripts/db/connect.php");
include_once 'src/scripts/foodAction/foodAction.php';

if (empty($_SESSION["user_id"])) {
    header('location:login.php');
    exit;
}
foreach ($_SESSION["cart_item"] as $item) {
    $item_total += ($item["price"] * $item["quantity"]);
    if ($_POST['submit']) {
        $orderType = isset($_POST['order_type']) ? $_POST['order_type'] : '';

        $stmt_rs = $db->prepare("SELECT rs_id FROM foods WHERE title = :title");
        $stmt_rs->execute([':title' => $item["title"]]);
        $row = $stmt_rs->fetch(PDO::FETCH_ASSOC);
        $rs_id = $row['rs_id'] ?? 0;

        $stmt = $db->prepare("INSERT INTO users_orders (u_id, title, quantity, price, order_type, rs_id) VALUES (:u_id, :title, :quantity, :price, :order_type, :rs_id)");
        $stmt->execute([
            ':u_id' => $_SESSION["user_id"],
            ':title' => $item["title"],
            ':quantity' => $item["quantity"],
            ':price' => $item["price"],
            ':order_type' => $orderType,
            ':rs_id' => $rs_id
        ]);

        unset($_SESSION["cart_item"]);
        unset($item["title"]);
        unset($item["quantity"]);
        unset($item["price"]);
        echo "<script>alert('Thank you. Your Order has been placed!');</script>";
        echo "<script>window.location.replace('orders.php');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CenDash | Checkout</title>
    <link rel="icon" href="/assets/images/logo.png">
    <link rel="stylesheet" href="src/styles/css/loader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="src/styles/css/navbar.css">
    <link rel="stylesheet" href="src/styles/css/main.css">
    <link rel="stylesheet" href="src/styles/css/footer.css">
    <link rel="stylesheet" href="src/styles/css/tailwind.css">
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

    <div class="page-wrapper">
        <div class="container" style="padding-top: 2rem; padding-bottom: 4rem;">
            <div class="checkout-header">
                <h2>Secure Checkout</h2>
                <p>Complete your order and satisfy your cravings.</p>
            </div>

            <form action="" method="post" class="checkout-grid">
                <!-- Left Column: Order Details -->
                <div class="details-column">
                    <div class="checkout-card">
                        <h3 class="card-title"><i class="fa-solid fa-utensils"></i> Order Type</h3>
                        <div class="order-type-options">
                            <label class="custom-radio-card">
                                <input name="order_type" value="Dine In" type="radio" checked>
                                <div class="radio-content">
                                    <i class="fa-solid fa-chair"></i>
                                    <span>Dine In</span>
                                </div>
                            </label>
                            <label class="custom-radio-card">
                                <input name="order_type" value="Take Out" type="radio">
                                <div class="radio-content">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                    <span>Take Out</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="checkout-card">
                        <h3 class="card-title"><i class="fa-solid fa-wallet"></i> Payment Method</h3>
                        <div class="payment-options">
                            <label class="payment-option-row">
                                <input name="mod" value="COD" type="radio" checked>
                                <span class="payment-label">Cash Payment</span>
                                <i class="fa-solid fa-money-bill-wave"></i>
                            </label>
                            <label class="payment-option-row disabled">
                                <input name="mod" value="paypal" type="radio" disabled>
                                <span class="payment-label">Online Payment (Coming Soon)</span>
                                <div class="card-icons">
                                    <i class="fa-brands fa-cc-visa"></i>
                                    <i class="fa-brands fa-cc-mastercard"></i>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Summary -->
                <div class="summary-column">
                    <div class="checkout-card sticky-summary">
                        <h3 class="card-title">Order Summary</h3>
                        <div class="summary-body">
                            <div class="summary-row total">
                                <span>Total Amount</span>
                                <span class="amount">₱<?= $item_total ?></span>
                            </div>
                            <p class="summary-note">Please review your order before confirming.</p>

                            <input type="submit" onclick="return confirm('Do you want to confirm the order?');"
                                name="submit" class="btn-confirm-order" value="Place Order">
                        </div>
                    </div>
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
    </div>
    <script src="src/scripts/userAction/userAction.js"></script>
    <script src="src/scripts/main.js"></script>
</body>

</html>