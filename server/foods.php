<?php
include("src/scripts/db/connect.php");
include("src/scripts/foodAction/foodAction.php");

$res_id = isset($_GET['res_id']) ? intval($_GET['res_id']) : 0;

$stmt_vendor = $db->prepare("SELECT * FROM vendor WHERE rs_id = :rs_id");
$stmt_vendor->execute([':rs_id' => $res_id]);
$rows = $stmt_vendor->fetch(PDO::FETCH_ASSOC);

$stmt_products = $db->prepare("SELECT * FROM foods WHERE rs_id = :rs_id");
$stmt_products->execute([':rs_id' => $res_id]);
$products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);

$item_total = 0;

if (empty($rows['image']) && empty($rows['title'])) {
    echo '<script>alert("Apologies, no CenDash food were found.");</script>';
    header("refresh: 0; url=.");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CenDash | Foods</title>
    <link rel="stylesheet" href="src/styles/css/tailwind.css">
    <link rel="stylesheet" href="src/styles/css/loader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="src/styles/css/navbar.css">
    <link rel="stylesheet" href="src/styles/css/footer.css">
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
    <div class="page-wrapper">
        <!-- Vendor Hero -->
        <section class="vendor-hero"
            style="background-image: url('/assets/vendorassets/<?php echo $rows['image']; ?>');">
            <div class="overlay"></div>
            <div class="container">
                <div class="vendor-info">
                    <h1><?php echo $rows['title']; ?></h1>
                    <p class="address"><i class="fa-solid fa-location-dot"></i> Central Market, New Era, Quezon City</p>
                    <div class="rating">
                        <i class="fa-solid fa-star"></i> 4.8 (500+ ratings)
                    </div>
                </div>
            </div>
        </section>

        <div class="container main-content-grid">
            <!-- Left Column: Menu -->
            <div class="menu-column">
                <h3 class="section-title">Menu</h3>
                <div class="menu-grid">
                    <?php
                    if (!empty($products)) {
                        foreach ($products as $product) {
                            ?>
                            <div class="menu-item-card">
                                <form method="post"
                                    action='foods.php?res_id=<?php echo $_GET['res_id']; ?>&action=add&id=<?php echo $product['d_id']; ?>'>
                                    <div class="menu-item-content">
                                        <div class="image-wrapper">
                                            <?php echo '<img src="/assets/vendorassets/foods/' . $product['img'] . '" loading="lazy">'; ?>
                                        </div>
                                        <div class="text-content">
                                            <h4><?php echo $product['title']; ?></h4>
                                            <p><?php echo $product['slogan']; ?></p>
                                            <div class="price">₱<?php echo $product['price']; ?></div>
                                        </div>
                                        <div class="action-column">
                                            <input type="number" name="quantity" value="1" min="1" class="qty-input" />
                                            <button type="submit" class="btn-add">
                                                <i class="fa-solid fa-plus"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p class="no-items">No items available.</p>';
                    }
                    ?>
                </div>
            </div>

            <!-- Right Column: Cart (Sticky) -->
            <div class="cart-column">
                <div class="cart-widget sticky-cart">
                    <div class="widget-header">
                        <h3>Your Order</h3>
                    </div>
                    <div class="widget-body">
                        <?php
                        if (empty($_SESSION["cart_item"])) {
                            echo '<div class="empty-cart"><i class="fa-solid fa-basket-shopping"></i><p>Your cart is empty</p></div>';
                        } else {
                            foreach ($_SESSION["cart_item"] as $item) {
                                ?>
                                <div class="cart-item">
                                    <div class="item-name">
                                        <span><?php echo $item["quantity"]; ?>x</span>
                                        <?php echo $item["title"]; ?>
                                    </div>
                                    <div class="item-price">₱<?php echo $item["price"] * $item["quantity"]; ?></div>
                                    <a href="?res_id=<?php echo $_GET['res_id']; ?>&action=remove&id=<?php echo $item["d_id"]; ?>"
                                        class="remove-btn">
                                        <i class="fa-solid fa-xmark"></i>
                                    </a>
                                </div>
                                <?php
                                $item_total += ($item["price"] * $item["quantity"]);
                            }
                        }
                        ?>

                        <div class="cart-summary">
                            <div class="total-row">
                                <span>Total</span>
                                <span class="total-price">₱<?= $item_total ?></span>
                            </div>
                            <a href="checkout.php?res_id=<?= $_GET['res_id'] ?>&action=check"
                                class="btn-checkout <?= $item_total == 0 ? 'disabled' : '' ?>">
                                Checkout
                            </a>
                        </div>
                    </div>
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
                    <p><a href="../"><b>&copy; 2026</b>, <b>CenDash</b>.</a> All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
    <script src="src/scripts/userAction/userAction.js"></script>
    <script src="src/scripts/main.js"></script>
</body>

</html>