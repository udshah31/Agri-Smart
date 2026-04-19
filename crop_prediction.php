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
                    <span class="badge-vibrant mb-3 d-inline-block" style="background-color: #ef4444;">Prediction</span>
                    <h1 class="display-3 text-gradient font-weight-bold">Crop Prediction System</h1>
                    <p class="lead mt-3">Predict which crops can be grown in a given region and season.</p>
                </div>
            </div>

            <div class="row row-content mt-5 justify-content-center">
                <div class="col-md-10">
                    <div class="glass-card mb-4" style="border-top: 5px solid #ef4444;">
                        <form role="form" action="#" method="post">
                            <h3 class="title mb-4" style="color: #ef4444; border-bottom: 2px solid rgba(239, 68, 68, 0.2); padding-bottom: 10px;">Input Parameters</h3>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label>State</label>
                                        <select onchange="print_city('state', this.selectedIndex);" id="sts" name="stt" class="form-control-modern" required style="appearance: auto;"></select>
                                        <script language="javascript">print_state("sts");</script>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label>District</label>
                                        <select id="state" name="district" class="form-control-modern" required style="appearance: auto;">
                                            <option value="">Select District</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label>Season</label>
                                        <select name="Season" class="form-control-modern" required style="appearance: auto;">
                                            <option value="">Select Season</option>
                                            <option value="Kharif">Kharif</option>
                                            <option value="Whole Year">Whole Year</option>
                                            <option value="Autumn">Autumn</option>
                                            <option value="Rabi">Rabi</option>
                                            <option value="Summer">Summer</option>
                                            <option value="Winter">Winter</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" name="Crop_Predict" class="btn btn-vibrant btn-block btn-lg" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); letter-spacing: 2px;">PREDICT CROPS</button>
                            </div>
                        </form>
                    </div>

                    <?php 
                    if(isset($_POST['Crop_Predict'])){
                        $state=trim($_POST['stt']);
                        $district=trim($_POST['district']);
                        $season=trim($_POST['Season']);

                        $JsonState=json_encode($state);
                        $JsonDistrict=json_encode($district);
                        $JsonSeason=json_encode($season);
                        
                        $command = escapeshellcmd("venv/bin/python ML/crop_prediction/ZDecision_Tree_Model_Call.py $JsonState $JsonDistrict $JsonSeason");
                        $output = shell_exec($command);
                        
                        echo '<div class="glass-card mb-4" style="background: rgba(239, 68, 68, 0.08); border-left: 5px solid #ef4444; animation: fadeIn 0.5s ease-out;">';
                        echo '<h3 class="title" style="color: #ef4444;"><i class="fas fa-check-circle mr-2"></i>Result</h3>';
                        
                        if ($output) {
                            echo '<p class="lead mt-3 mb-0" style="font-weight: 600;">Crops grown in <strong>' . htmlspecialchars($district) . '</strong> during the <strong>' . htmlspecialchars($season) . '</strong> season:</p>';
                            echo '<p class="lead mt-2" style="color: var(--color-dark); font-size: 1.3rem;">' . htmlspecialchars($output) . '</p>';
                        } else {
                            echo '<p class="lead mt-3 mb-0 text-danger" style="font-weight: 600;"><i class="fas fa-exclamation-triangle mr-2"></i>No prediction available. Please check your inputs.</p>';
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
