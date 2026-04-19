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
                    <span class="badge-vibrant mb-3 d-inline-block" style="background-color: #3b82f6;">Prediction</span>
                    <h1 class="display-3 text-gradient font-weight-bold">Rainfall Prediction System</h1>
                    <p class="lead mt-3">Predict rainfall for a specific region and month using our ML models.</p>
                </div>
            </div>

            <div class="row row-content mt-5 justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="glass-card mb-4" style="border-top: 5px solid #3b82f6;">
                        <form action="#" method="post">
                            <h3 class="title mb-4" style="color: #3b82f6; border-bottom: 2px solid rgba(59, 130, 246, 0.2); padding-bottom: 10px;">Input Parameters</h3>
                            
                            <div class="form-group-modern">
                                <label for="region-select">Region</label>
                                <select id="region-select" name="region" required class="form-control-modern" style="appearance: auto;">
                                    <option value="">Select Region</option>
                                </select>
                                <script> print_region("region-select"); </script>
                            </div>

                            <div class="form-group-modern">
                                <label for="month-select">Month</label>
                                <select id="month-select" name="month" required class="form-control-modern" style="appearance: auto;">
                                    <option value="">Select Month</option>
                                </select>
                                <script> print_months("month-select"); </script>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" name="Rainfall_Predict" class="btn btn-vibrant btn-block btn-lg" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); letter-spacing: 2px;">PREDICT RAINFALL</button>
                            </div>
                        </form>
                    </div>

                    <?php 
                    if(isset($_POST['Rainfall_Predict'])){
                        $region = trim($_POST['region']);
                        $month = trim($_POST['month']);

                        $Jregion = json_encode($region);
                        $Jmonth = json_encode($month);

                        $command = escapeshellcmd("venv/bin/python ML/rainfall_prediction/rainfall_prediction.py $Jregion $Jmonth ");
                        $output = shell_exec($command);
                        
                        echo '<div class="glass-card mb-4" style="background: rgba(59, 130, 246, 0.08); border-left: 5px solid #3b82f6; animation: fadeIn 0.5s ease-out;">';
                        echo '<h3 class="title" style="color: #3b82f6;"><i class="fas fa-cloud-rain mr-2"></i>Predicted Rainfall</h3>';
                        echo '<p class="mt-3">For the region <strong>' . htmlspecialchars($region) . '</strong> in the month of <strong>' . htmlspecialchars($month) . '</strong>:</p>';
                        
                        if ($output) {
                            echo '<p class="lead mt-2 mb-0" style="font-weight: 600; font-size: 1.5rem; color: var(--color-dark);">' . htmlspecialchars($output) . ' mm</p>';
                        } else {
                            echo '<p class="lead mt-2 mb-0 text-danger" style="font-weight: 600;"><i class="fas fa-exclamation-triangle mr-2"></i>Prediction could not be generated. Try again.</p>';
                        }
                        
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <?php require("footer.php");?>
</body>
<style>
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
</html>
