<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}

// Display user dashboard
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include ('header.php'); ?>
<body class="bg-white" id="top">
    
    <?php include ('navbar.php'); ?>

    <!-- Hero Section -->
    <div class="hero-section text-center" style="background: url('assets/img/empty.webp') no-repeat center center; background-size: cover; padding: 100px 0; position: relative;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.4); z-index: 1;"></div>
        <div class="container position-relative" style="z-index: 2;">
            <h1 class="display-3 text-white font-weight-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.5);">Welcome back, <?php echo htmlspecialchars($username); ?>!</h1>
            <p class="lead text-white font-weight-light mt-3" style="text-shadow: 1px 1px 5px rgba(0,0,0,0.5);">
                Transforming Agriculture with Smart Technology
            </p>
        </div>
    </div>

    <!-- Features Dashboard -->
    <div class="section features-6 text-dark bg-light" id="dashboard-items" style="padding: 60px 0;">
        <div class="container">
            <div class="row text-center">
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="glass-card shadow-sm h-100" style="padding: 30px;">
                        <div class="icon icon-lg icon-shape icon-shape-success shadow rounded-circle mb-4 mx-auto" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background: var(--color-primary); color: white; font-size: 24px;">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h4 class="title text-primary">Crop Recommendation</h4>
                        <p class="description mt-3">Find out the best crop to grow given your soil profile and climate.</p>
                        <a href="crop_recommendation.php" class="btn btn-vibrant mt-3">Explore -></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="glass-card shadow-sm h-100" style="padding: 30px;">
                        <div class="icon icon-lg icon-shape icon-shape-success shadow rounded-circle mb-4 mx-auto" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background: var(--color-secondary); color: white; font-size: 24px;">
                            <i class="fas fa-flask"></i>
                        </div>
                        <h4 class="title text-secondary">Fertilizer Recommendation</h4>
                        <p class="description mt-3">Get tailored fertilizer recommendations for your farm's health.</p>
                        <a href="fertilizer_recommendation.php" class="btn btn-vibrant mt-3">Explore -></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="glass-card shadow-sm h-100" style="padding: 30px;">
                        <div class="icon icon-lg icon-shape icon-shape-success shadow rounded-circle mb-4 mx-auto" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background: var(--color-accent); color: white; font-size: 24px;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4 class="title" style="color: var(--color-accent);">Yield Prediction</h4>
                        <p class="description mt-3">Estimate crop yield accurately based on advanced ML models.</p>
                        <a href="yield_prediction.php" class="btn btn-vibrant mt-3">Explore -></a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php require("footer.php");?>

</body>
</html>
