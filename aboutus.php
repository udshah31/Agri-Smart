<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<?php include('header.php'); ?>
<body class="bg-white" id="top">
    
    <?php include('navbar.php'); ?>

    <!-- Hero Section -->
    <section class="section section-shaped section-lg" style="margin-top: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto text-center">
                    <span class="badge-vibrant mb-3 d-inline-block">About Us</span>
                    <h1 class="display-3 text-gradient font-weight-bold">AgriSmart Mission</h1>
                    <p class="lead mt-3">Empowering farmers with technology-driven solutions for a sustainable future.</p>
                </div>
            </div>

            <div class="row row-content mt-5 justify-content-center">
                <div class="col-md-10">
                    <div class="glass-card mb-5" style="border-top: 5px solid var(--color-primary);">
                        <section class="mission-section d-flex flex-wrap align-items-center">
                            <div class="col-md-6 order-md-1 order-2 mt-4 mt-md-0 px-md-4">
                                <h2 class="title text-primary"><i class="fas fa-bullseye mr-2"></i>Our Mission</h2>
                                <p class="description mt-3" style="color: var(--color-dark); font-size: 1.1rem; line-height: 1.8;">
                                    AgriSmart is dedicated to transforming agriculture by integrating technology-driven solutions to enhance farming practices. Through AI, IoT, and data analytics, we empower farmers with smarter tools for making informed decisions, optimizing crop yield, and ensuring sustainable and efficient farming. Our mission is to support farmers with tailored crop and fertilizer recommendations, real-time soil health analysis, and waste management solutions, while promoting eco-friendly practices for a greener future.
                                </p>
                            </div>
                            <div class="col-md-6 order-md-2 order-1 text-center">
                                <img src="assets/img/mission.png" alt="Our Mission" class="img-fluid rounded shadow-sm" style="max-height: 300px; border-radius: 15px;">
                            </div>
                        </section>
                    </div>

                    <div class="glass-card mb-5" style="border-top: 5px solid var(--color-secondary);">
                        <section class="technology-section d-flex flex-wrap align-items-center">
                            <div class="col-md-6 order-1 text-center">
                                <img src="assets/img/technology.png" alt="Our Technology and Solutions" class="img-fluid rounded shadow-sm" style="max-height: 300px; border-radius: 15px;">
                            </div>
                            <div class="col-md-6 order-2 mt-4 mt-md-0 px-md-4">
                                <h3 class="title" style="color: var(--color-secondary);"><i class="fas fa-microchip mr-2"></i>Our Technology and Solutions</h3>
                                <p class="description mt-3" style="color: var(--color-dark); font-size: 1.1rem; line-height: 1.8;">
                                    At AgriSmart, we leverage cutting-edge technologies to revolutionize agriculture. Our platform provides various solutions like personalized crop recommendations based on environmental conditions, precision-based fertilizer suggestions for higher yield and sustainability, and continuous soil health monitoring for making data-driven decisions. We also offer an efficient waste management system to minimize environmental impact and a weather forecasting system that helps farmers plan better with rain predictions and optimal water usage. Additionally, we keep farmers updated with the latest agricultural trends and industry news to help them stay ahead.
                                </p>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require("footer.php");?>
</body>
</html>