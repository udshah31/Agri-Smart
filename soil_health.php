<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<?php include('header.php'); ?>
<body class="bg-white" id="top">
    
    <?php include('navbar.php'); ?>

    <section class="section section-shaped section-lg" style="margin-top: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto text-center">
                    <span class="badge-vibrant mb-3 d-inline-block">IoT Analysis</span>
                    <h1 class="display-3 text-gradient font-weight-bold">Real-Time Soil Health Analysis</h1>
                    <p class="lead mt-3">Monitor pH levels of your soil in real-time and receive actionable recommendations.</p>
                </div>
            </div>

            <div class="row row-content mt-5 justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="glass-card mb-4" style="border-top: 5px solid var(--color-secondary);">
                        <h3 class="title text-primary mb-4" style="border-bottom: 2px solid rgba(16, 185, 129, 0.2); padding-bottom: 10px;">
                            <i class="fas fa-flask mr-2"></i>Soil pH Monitor
                        </h3>
                        
                        <div class="row text-center mb-4">
                            <div class="col-md-6 mx-auto">
                                <div class="glass-card" style="background: rgba(13, 148, 136, 0.08); border: 2px solid rgba(13, 148, 136, 0.2);">
                                    <i class="fas fa-vial fa-2x mb-3" style="color: var(--color-secondary);"></i>
                                    <h5 class="text-muted mb-1">Latest pH Value</h5>
                                    <h2 class="font-weight-bold" id="ph_value" style="color: var(--color-secondary); font-size: 2.5rem;">Loading...</h2>
                                </div>
                            </div>
                        </div>

                        <div id="result"></div>

                        <div class="text-center mt-3">
                            <small class="text-muted"><i class="fas fa-sync-alt mr-2"></i>Auto-refreshes every 3 seconds</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require("footer.php"); ?>

    <script>
        function fetchPHData() {
            fetch('get_ph.php')
                .then(response => response.json())
                .then(data => {
                    if (data.ph_value !== null) {
                        document.getElementById('ph_value').innerText = data.ph_value;
                        getRecommendation(data.ph_value);
                    } else {
                        document.getElementById('ph_value').innerText = "No Data";
                    }
                })
                .catch(error => {
                    document.getElementById('ph_value').innerText = "Offline";
                    console.error('Error fetching pH data:', error);
                });
        }

        function getRecommendation(pH) {
            fetch('get_recommendation.php?ph_value=' + pH)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('result').innerHTML = data;
                })
                .catch(error => console.error('Error fetching recommendation:', error));
        }

        setInterval(fetchPHData, 3000);
        fetchPHData();
    </script>
</body>
</html>
