<?php
include("src/scripts/db/connect.php");
$query_res = db_query($db, "SELECT * FROM foods ORDER BY RANDOM() LIMIT 6");
$res = db_query($db, "SELECT * FROM vendor_group");
$ress = db_query($db, "SELECT * FROM vendor");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CenDash | Home</title>
    <link rel="icon" href="/assets/images/logo.png">
    <link rel="stylesheet" href="src/styles/css/tailwind.css">
    <link rel="stylesheet" href="src/styles/css/loader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="src/styles/css/footer.css">
    <link rel="stylesheet" href="src/styles/css/navbar.css">
    <link rel="stylesheet" href="src/styles/css/main.css">
</head>

<body class="home">
    <div class="parallax">
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


        <section class="hero-modern">
            <div class="hero-content">
                <h1 class="hero-title">CenDash<br><span class="highlight">Dining Reimagined</span></h1>
                <p class="hero-subtitle">Skip the lines. Order ahead. Eat better.</p>
                <div class="search-bar-container">
                    <form action="search.php" method="GET" class="search-form">
                        <i class="fa-solid fa-search search-icon"></i>
                        <input type="text" name="q" placeholder="What are you craving?" class="search-input">
                        <button type="submit" class="search-button">Search</button>
                    </form>
                </div>
            </div>
            <div class="hero-overlay"></div>
        </section>
        <section class="popular">
            <div class="title">
                <h2>Explore popular foods</h2>
                <p class="lead">With CenDash you can explore popular foods with ease!</p>
            </div>
            <div class="food-item-container">
                <?php
                while ($r = db_fetch_array($query_res)) {
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
                              <a href="foods.php?res_id=' . $r['rs_id'] . '" class="btn theme-btn-dash">Order Now</a>
                            </div>
                        </div>
                </div>
                ';
                } ?>
            </div>
        </section>
        <!-- Categories Section (Replacing Steps) -->
        <section class="categories-section">
            <div class="container">
                <div class="section-header">
                    <h2>Browse Categories</h2>
                </div>
                <div class="categories-grid">
                    <?php
                    // Reset pointer for vendor groups since we used it? No, $res was not used yet.
                    // Actually $res is used in the filter below. We can iterate it here first, then seek back or re-query?
                    // To be safe and efficient, let's fetch all groups into an array.
                    $categories = [];
                    while ($cat = db_fetch_array($res)) {
                        $categories[] = $cat;
                    }

                    // Icon Mapping
                    $icons = [
                        'Heavy Meal' => 'fa-burger',
                        'Snacks' => 'fa-cookie-bite',
                        'Drinks' => 'fa-mug-hot',
                        'Desserts' => 'fa-ice-cream',
                        'Vegan' => 'fa-carrot',
                        'Default' => 'fa-utensils'
                    ];

                    // Display categories
                    foreach ($categories as $cat) {
                        $iconClass = isset($icons[$cat['c_name']]) ? $icons[$cat['c_name']] : $icons['Default'];
                        echo '
                        <a href="#" class="category-card" data-filter=".' . $cat['c_name'] . '">
                            <div class="category-icon">
                                <i class="fa-solid ' . $iconClass . '"></i>
                            </div>
                            <span class="category-name">' . $cat['c_name'] . '</span>
                        </a>';
                    }
                    ?>
                </div>
            </div>
        </section>
        <section class="vendor-view">
            <div class="container">
                <div class="title-block">
                    <h2>Featured Vendors</h2>
                    <p class="lead">Top-rated partners delivering happiness.</p>
                </div>

                <div class="featured-vendors-grid">
                    <?php
                    // Reset or re-fetch vendors if needed, currently $ress is the resource
                    // We need to loop through $ress. 
                    // Note: We are not filtering anymore, so we just show them all.
                    // Ensure we start from the beginning if $ress was used before?
                    // Usually db_query returns a resource that can be iterated once unless reset. 
                    // Check previous usages. $ress was defined at the top: $ress = db_query($db, "SELECT * FROM vendor");
                    // It hasn't been iterated yet in the previous visible code blocks (the categories loop used $res, not $ress).
                    
                    while ($rows = db_fetch_array($ress)) {
                        $query = db_query($db, "SELECT * FROM vendor_group WHERE c_id='" . $rows['c_id'] . "'");
                        $rowss = db_fetch_array($query);
                        $categoryName = $rowss['c_name'];

                        echo ' 
                        <div class="vendor-card">
                            <div class="vendor-logo">
                                <img src="/assets/vendorassets/' . $rows['image'] . '" alt="' . $rows['title'] . '" loading="lazy">
                            </div>
                            <div class="vendor-details">
                                <h3>' . $rows['title'] . '</h3>
                                <span class="vendor-badge">' . $categoryName . '</span>
                            </div>
                            <div class="vendor-arrow">
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                            <a href="foods.php?res_id=' . $rows['rs_id'] . '" class="stretched-link"></a>
                        </div>';
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
    <script src="src/scripts/isotope.min.js"></script>
    <script src="src/scripts/userAction/userAction.js"></script>
    <script src="src/scripts/main.js"></script>
</body>

</html>