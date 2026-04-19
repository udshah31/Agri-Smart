<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<?php include ('header.php'); ?>
<body class="bg-white" id="top">
    
    <?php include ('navbar.php'); ?>

    <section class="section section-shaped section-lg" style="margin-top: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto text-center">
                    <span class="badge-vibrant mb-3 d-inline-block">Recommendation</span>
                    <h1 class="display-3 text-gradient font-weight-bold">Crop Recommendation System</h1>
                    <p class="lead mt-3">Enter the required environmental and soil metrics to get crop recommendations driven by our ML models.</p>
                </div>
            </div>

            <div class="row row-content mt-5 justify-content-center">
                <div class="col-md-10">
                    <div class="glass-card mb-4" style="border-top: 5px solid var(--color-primary);">
                        <form role="form" action="#" method="post">
                            <h3 class="title text-primary mb-4" style="border-bottom: 2px solid rgba(16, 185, 129, 0.2); padding-bottom: 10px;">Input Parameters</h3>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label>Nitrogen (N)</label>
                                        <input type="number" name="n" placeholder="Eg: 90" required class="form-control-modern">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label>Phosphorus (P)</label>
                                        <input type="number" name="p" placeholder="Eg: 42" required class="form-control-modern">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label>Potassium (K)</label>
                                        <input type="number" name="k" placeholder="Eg: 43" required class="form-control-modern">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label>Temperature (°C)</label>
                                        <input type="number" name="t" placeholder="Eg: 21" step="0.01" required class="form-control-modern">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label>Humidity (%)</label>
                                        <input type="number" name="h" placeholder="Eg: 82" step="0.01" required class="form-control-modern">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label>Soil pH</label>
                                        <input type="number" name="ph" placeholder="Eg: 6.5" step="0.01" required class="form-control-modern">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label>Rainfall (mm)</label>
                                        <input type="number" name="r" placeholder="Eg: 203" step="0.01" required class="form-control-modern">
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" name="Crop_Recommend" class="btn btn-vibrant btn-block btn-lg" style="letter-spacing: 2px;">PREDICT BEST CROP</button>
                            </div>
                        </form>
                    </div>

                    <?php 
                    if (isset($_POST['Crop_Recommend'])) {
                        $n = trim($_POST['n']);
                        $p = trim($_POST['p']);
                        $k = trim($_POST['k']);
                        $t = trim($_POST['t']);
                        $h = trim($_POST['h']);
                        $ph = trim($_POST['ph']);
                        $r = trim($_POST['r']);

                        $Jsonn = json_encode($n);
                        $Jsonp = json_encode($p);
                        $Jsonk = json_encode($k);
                        $Jsont = json_encode($t);
                        $Jsonh = json_encode($h);
                        $Jsonph = json_encode($ph);
                        $Jsonr = json_encode($r);

                        $command = escapeshellcmd("venv/bin/python ML/crop_recommendation/recommend.py $Jsonn $Jsonp $Jsonk $Jsont $Jsonh $Jsonph $Jsonr");
                        $output = shell_exec($command);
						
                        echo '<div class="glass-card mb-4" style="background: rgba(16, 185, 129, 0.1); border-left: 5px solid var(--color-primary); animation: fadeIn 0.5s ease-out;">';
                        echo '<h3 class="title text-primary"><i class="fas fa-check-circle mr-2"></i>Result</h3>';
                        
                        if ($output) {
                            echo '<p class="lead mt-3 mb-0" style="font-weight: 600;">Recommended Crop is: <span style="color: var(--color-dark); font-size: 1.5rem; text-transform: capitalize;">' . htmlspecialchars($output) . '</span></p>';
                        } else {
                            echo '<p class="lead mt-3 mb-0 text-danger" style="font-weight: 600;"><i class="fas fa-exclamation-triangle mr-2"></i>No recommendation found. Please check your input values or ML model configuration.</p>';
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