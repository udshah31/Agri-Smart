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
                    <span class="badge-vibrant mb-3 d-inline-block">Recommendation</span>
                    <h1 class="display-3 text-gradient font-weight-bold">Fertilizer Recommendation System</h1>
                    <p class="lead mt-3">Determine the optimal fertilizer type for your specific crop and soil
                        conditions.</p>
                </div>
            </div>

            <div class="row row-content mt-5 justify-content-center">
                <div class="col-md-10">
                    <div class="glass-card mb-4" style="border-top: 5px solid var(--color-secondary);">
                        <form role="form" action="#" method="post">
                            <h3 class="title text-primary ">Input Parameters</h3>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label>Nitrogen (N)</label>
                                        <input type="number" name="n" placeholder="Eg: 37" required
                                            class="form-control-modern">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label>Phosphorus (P)</label>
                                        <input type="number" name="p" placeholder="Eg: 0" required
                                            class="form-control-modern">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label>Potassium (K)</label>
                                        <input type="number" name="k" placeholder="Eg: 0" required
                                            class="form-control-modern">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label>Temperature (°C)</label>
                                        <input type="number" name="t" placeholder="Eg: 26" required
                                            class="form-control-modern">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label>Humidity (%)</label>
                                        <input type="number" name="h" placeholder="Eg: 52" required
                                            class="form-control-modern">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label>Soil Moisture</label>
                                        <input type="number" name="soilMoisture" placeholder="Eg: 38" required
                                            class="form-control-modern">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label>Soil Type</label>
                                        <select name="soil" class="form-control-modern" required
                                            style="appearance: auto;">
                                            <option value="">Select Soil Type</option>
                                            <option value="Sandy">Sandy</option>
                                            <option value="Loamy">Loamy</option>
                                            <option value="Black">Black</option>
                                            <option value="Red">Red</option>
                                            <option value="Clayey">Clayey</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label>Crop Type</label>
                                        <select name="crop" class="form-control-modern" required
                                            style="appearance: auto;">
                                            <option value="">Select Crop</option>
                                            <option value="Maize">Maize</option>
                                            <option value="Sugarcane">Sugarcane</option>
                                            <option value="Cotton">Cotton</option>
                                            <option value="Tobacco">Tobacco</option>
                                            <option value="Paddy">Paddy</option>
                                            <option value="Barley">Barley</option>
                                            <option value="Wheat">Wheat</option>
                                            <option value="Millets">Millets</option>
                                            <option value="Oil seeds">Oil seeds</option>
                                            <option value="Pulses">Pulses</option>
                                            <option value="Ground Nuts">Ground Nuts</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" name="Fert_Recommend" class="btn btn-vibrant btn-block btn-lg"
                                    style="letter-spacing: 2px;">RECOMMEND FERTILIZER</button>
                            </div>
                        </form>
                    </div>

                    <?php
                    if (isset($_POST['Fert_Recommend'])) {
                        $n = trim($_POST['n']);
                        $p = trim($_POST['p']);
                        $k = trim($_POST['k']);
                        $t = trim($_POST['t']);
                        $h = trim($_POST['h']);
                        $sm = trim($_POST['soilMoisture']);
                        $soil = trim($_POST['soil']);
                        $crop = trim($_POST['crop']);

                        $Jsonn = json_encode($n);
                        $Jsonp = json_encode($p);
                        $Jsonk = json_encode($k);
                        $Jsont = json_encode($t);
                        $Jsonh = json_encode($h);
                        $Jsonsm = json_encode($sm);
                        $Jsonsoil = json_encode($soil);
                        $Jsoncrop = json_encode($crop);

                        $command = escapeshellcmd("venv/bin/python ML/fertilizer_recommendation/fertilizer_recommendation.py $Jsonn $Jsonp $Jsonk $Jsont $Jsonh $Jsonsm $Jsonsoil $Jsoncrop ");
                        $output = shell_exec($command);

                        echo '<div class="glass-card mb-4" style="background: rgba(13, 148, 136, 0.1); border-left: 5px solid var(--color-secondary); animation: fadeIn 0.5s ease-out;">';
                        echo '<h3 class="title text-secondary"><i class="fas fa-check-circle mr-2"></i>Result</h3>';

                        if ($output) {
                            echo '<p class="lead mt-3 mb-0" style="font-weight: 600;">Recommended Fertilizer is: <span style="color: var(--color-dark); font-size: 1.5rem; text-transform: capitalize;">' . htmlspecialchars($output) . '</span></p>';
                        } else {
                            echo '<p class="lead mt-3 mb-0 text-danger" style="font-weight: 600;"><i class="fas fa-exclamation-triangle mr-2"></i>No recommendation found. Please check your input values.</p>';
                        }

                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <?php require("footer.php"); ?>
</body>
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

</html>