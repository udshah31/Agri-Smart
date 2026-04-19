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
                    <span class="badge-vibrant mb-3 d-inline-block" style="background-color: var(--color-accent);">Prediction</span>
                    <h1 class="display-3 text-gradient font-weight-bold">Yield Prediction System</h1>
                    <p class="lead mt-3">Predict crop yield accurately based on region, season, and area using advanced ML models.</p>
                </div>
            </div>

            <div class="row row-content mt-5 justify-content-center">
                <div class="col-md-10">
                    <div class="glass-card mb-4" style="border-top: 5px solid var(--color-accent);">
                        <form role="form" action="#" method="post">
                            <h3 class="title text-primary">Input Parameters</h3>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label>State</label>
                                        <select onchange="print_city('district', this.selectedIndex);" id="sts" name="state" class="form-control-modern" required style="appearance: auto;"></select>
                                        <script language="javascript">print_state("sts");</script>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label>District</label>
                                        <select id="district" name="district" class="form-control-modern" required style="appearance: auto;">
                                            <option value="">Select District</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label>Season</label>
                                        <select name="Season" class="form-control-modern" id="season" required style="appearance: auto;">
                                            <option value="">Select Season</option>
                                            <option value="Kharif">Kharif</option>
                                            <option value="Rabi">Rabi</option>
                                            <option value="Summer">Summer</option>
                                            <option value="Whole Year">Whole Year</option>
                                            <option value="Autumn">Autumn</option>
                                            <option value="Winter">Winter</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label>Crop</label>
                                        <select id="crop" class="form-control-modern" name="crops" required style="appearance: auto;">
                                            <option value="">Select crop</option>
                                            <!-- Dynamically populated or manual entry, we simulate it via external JS but fallback to hardcoded list if JS fails -->
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
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label>Area (Hectares)</label>
                                        <input type="number" step="0.01" name="area" placeholder="Eg: 12.5" required class="form-control-modern">
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" name="Yield_Predict" class="btn btn-vibrant btn-block btn-lg" style="background: linear-gradient(135deg, var(--color-accent) 0%, rgb(50, 160, 120) 100%); letter-spacing: 2px;">PREDICT YIELD</button>
                            </div>
                        </form>
                    </div>

                    <?php 
                    if(isset($_POST['Yield_Predict'])){
                        $state=trim($_POST['state']);
                        $district=trim($_POST['district']);
                        $season=trim($_POST['Season']);
                        $crops=trim($_POST['crops']);
                        $area=trim($_POST['area']);

                        $Jstate=json_encode($state);
                        $Jdistrict=json_encode($district);
                        $Jseason=json_encode($season);
                        $Jcrops=json_encode($crops);
                        $Jarea=json_encode($area);

                        $command = escapeshellcmd("venv/bin/python ML/yield_prediction/yield_prediction.py $Jstate $Jdistrict $Jseason $Jcrops $Jarea ");
                        $output = shell_exec($command);
						
                        echo '<div class="glass-card mb-4" style="background: rgba(52, 211, 153, 0.1); border-left: 5px solid var(--color-accent); animation: fadeIn 0.5s ease-out;">';
                        echo '<h3 class="title text-dark"><i class="fas fa-check-circle mr-2" style="color: var(--color-accent);"></i>Result</h3>';
                        
                        if ($output) {
                            echo '<p class="lead mt-3 mb-0" style="font-weight: 600;">Predicted crop yield (in Quintal) is: <span style="color: var(--color-dark); font-size: 1.5rem;">' . htmlspecialchars($output) . '</span></p>';
                        } else {
                            echo '<p class="lead mt-3 mb-0 text-danger" style="font-weight: 600;"><i class="fas fa-exclamation-triangle mr-2"></i>No yield prediction available. Please check your inputs.</p>';
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

<script> 
const updateCrops = function() {  
  const districtDropdown = document.getElementById('district');
  const seasonDropdown = document.getElementById('season');
  const cropDropdown = document.getElementById('crop');

  const selectedDistrict = districtDropdown.value.trim();
  const selectedSeason = seasonDropdown.value.trim();

  // If cropOptions is pulled via JS file (state_district_crops_dropdown.js)
  if (typeof cropOptions !== 'undefined' && selectedDistrict && selectedSeason) {
      cropDropdown.innerHTML = `
        <option value="">Select Crop</option>
        <option value="Maize">Maize</option>
        <option value="Sugarcane">Sugarcane</option>
        <option value="Cotton(lint)">Cotton</option>
        <option value="Tobacco">Tobacco</option>
        <option value="Rice">Paddy</option>
        <option value="Barley">Barley</option>
        <option value="Wheat">Wheat</option>
        <option value="Millets">Millets</option>
        <option value="other oilseeds">Oil seeds</option>
        <option value="Pulses total">Pulses</option>
        <option value="Groundnut">Ground Nuts</option>
      `;
      if(cropOptions[selectedDistrict] && cropOptions[selectedDistrict][selectedSeason]) {
          const options = cropOptions[selectedDistrict][selectedSeason];
          for (const option of options) {
            const optionElement = document.createElement('option');
            optionElement.value = option;
            optionElement.text = option;
            cropDropdown.appendChild(optionElement);
          }
      }
  }
};
document.getElementById("season").addEventListener("change", updateCrops);
document.getElementById("district").addEventListener("change", updateCrops);
</script>

<style>
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
</html>
