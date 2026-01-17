<?php
include("src/scripts/db/connect.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CenDash | Vendors</title>
    <link rel="icon" href="/assets/images/logo.png">
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
        <!-- Hero Section -->
        <section class="page-hero" style="position: relative; padding: 120px 0 60px; text-align: center;">
            <div class="container">
                <h1
                    style="font-family: 'Lexend', sans-serif; font-size: 3rem; margin-bottom: 1rem; color: var(--text-primary);">
                    Our Vendors</h1>
                <p style="color: var(--text-secondary); max-width: 600px; margin: 0 auto;">Explore the best food vendors
                    CenDash has to offer.</p>
            </div>
        </section>

        <section class="vendors-page-content" style="padding-bottom: 4rem;">
            <div class="container">
                <div class="featured-vendors-grid">
                    <?php
                    $ress = db_query($db, "SELECT * FROM vendor");
                    while ($rows = db_fetch_array($ress)) {
                        // Fetch category name
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
    <script src="src/scripts/userAction/userAction.js"></script>
    <script src="src/scripts/main.js"></script>
</body>

</html>