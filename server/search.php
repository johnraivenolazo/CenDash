<?php
include("src/scripts/db/connect.php");
$query = isset($_GET['q']) ? $_GET['q'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CenDash | Search Results</title>
    <link rel="icon" href="/assets/images/logo.png">
    <link rel="stylesheet" href="src/styles/css/tailwind.css">
    <link rel="stylesheet" href="src/styles/css/loader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="src/styles/css/footer.css">
    <link rel="stylesheet" href="src/styles/css/navbar.css">
    <link rel="stylesheet" href="src/styles/css/main.css">
</head>

<body>
    <div class="parallax">
        <?php include("src/includes/navbar.php"); ?>

        <section class="popular" style="min-height: 100vh; padding-top: 120px;">
            <div class="container">
                <div class="title">
                    <h2>Search Results for "
                        <?= htmlspecialchars($query) ?>"
                    </h2>
                    <p class="lead">We found the following items for you.</p>
                </div>

                <div class="food-item-container">
                    <?php
                    // Basic search implementation
                    if ($query) {
                        $search_sql = "SELECT * FROM foods WHERE title ILIKE '%$query%' OR slogan ILIKE '%$query%'";
                        $search_res = db_query($db, $search_sql);

                        if ($search_sql && $search_res) { // Check if query ran
                            // Since we don't have row count easily with the helper, just iterate
                            $found = false;
                            while ($r = db_fetch_array($search_res)) {
                                $found = true;
                                echo '
                                <div class="food-item">
                                        <div class="figure-wrap">
                                            <img src="/assets/vendorassets/foods/' . $r['img'] . '" alt="' . $r['title'] . '" loading="lazy">
                                        </div>
                                        <div class="content">
                                            <h5><a href="foods.php?res_id=' . $r['rs_id'] . '">' . $r['title'] . '</a></h5>
                                            <div class="product-name">' . $r['slogan'] . '</div>
                                            <div class="price-btn-block">
                                              <span class="price">₱' . $r['price'] . '</span>
                                              <a href="foods.php?res_id=' . $r['rs_id'] . '" class="btn">Order Now</a>
                                            </div>
                                        </div>
                                </div>';
                            }
                            if (!$found) {
                                echo '<p style="color: var(--text-secondary);">No items found matching your criteria.</p>';
                            }
                        }
                    } else {
                        echo '<p style="color: var(--text-secondary);">Please enter a search term.</p>';
                    }
                    ?>
                </div>
            </div>
        </section>

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
    <script src="src/scripts/main.js"></script>
</body>

</html>