<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

// Database Connection
$servername = "localhost";
$db_username = "root";
$password = "";
$dbname = "ecometrics";

$conn = new mysqli($servername, $db_username, $password, $dbname);

$MOISTURE_THRESHOLD = 70;
$moisture = "N/A";
$realTimeTemp = "N/A";
$timestamp = "N/A";
$motorStatus = "Unknown";
$motorStatusClass = "text-muted";

if (!$conn->connect_error) {
    $sql = "SELECT * FROM smart_irrigation ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $moisture = $row["moisture_level"];
        $realTimeTemp = $row["real_time_temp"];
        $timestamp = $row["timestamp"];
        
        if ($moisture < $MOISTURE_THRESHOLD) {
            $motorStatus = "OFF";
            $motorStatusClass = "text-danger";
        } else {
            $motorStatus = "ON";
            $motorStatusClass = "text-success";
        }
    }
    $conn->close();
} else {
    // Simulate data for demo when DB is unavailable
    $temperature = rand(210, 250) / 10;
    $realTimeTemp = $temperature . "°C";
    $moisture = rand(40, 90);
    $timestamp = date("Y-m-d H:i:s");
    if ($moisture < $MOISTURE_THRESHOLD) {
        $motorStatus = "OFF";
        $motorStatusClass = "text-danger";
    } else {
        $motorStatus = "ON";
        $motorStatusClass = "text-success";
    }
}
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
                    <span class="badge-vibrant mb-3 d-inline-block">IoT Monitoring</span>
                    <h1 class="display-3 text-gradient font-weight-bold">🌱 Smart Irrigation System</h1>
                    <p class="lead mt-3">Real-time monitoring of soil moisture and automated motor control.</p>
                </div>
            </div>

            <div class="row row-content mt-5 justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="glass-card mb-4" style="border-top: 5px solid var(--color-primary);">
                        <h3 class="title text-primary mb-4" style="border-bottom: 2px solid rgba(16, 185, 129, 0.2); padding-bottom: 10px;">
                            <i class="fas fa-tachometer-alt mr-2"></i>Live Dashboard
                        </h3>
                        
                        <div class="row text-center">
                            <div class="col-md-4 mb-4">
                                <div class="glass-card" style="background: rgba(41, 128, 185, 0.08); border: 2px solid rgba(41, 128, 185, 0.2);">
                                    <i class="fas fa-tint fa-2x mb-3" style="color: #2980b9;"></i>
                                    <h5 class="text-muted mb-1">Dryness Level</h5>
                                    <h2 class="font-weight-bold" style="color: #2980b9; font-size: 2.5rem;"><?= htmlspecialchars($moisture) ?>%</h2>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="glass-card" style="background: rgba(231, 76, 60, 0.08); border: 2px solid rgba(231, 76, 60, 0.2);">
                                    <i class="fas fa-thermometer-half fa-2x mb-3" style="color: #e74c3c;"></i>
                                    <h5 class="text-muted mb-1">Temperature</h5>
                                    <h2 class="font-weight-bold" style="color: #e74c3c; font-size: 2.5rem;"><?= htmlspecialchars($realTimeTemp) ?></h2>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="glass-card" style="background: rgba(46, 204, 113, 0.08); border: 2px solid rgba(46, 204, 113, 0.2);">
                                    <i class="fas fa-cog fa-2x mb-3 <?= $motorStatusClass ?>"></i>
                                    <h5 class="text-muted mb-1">Motor Status</h5>
                                    <h2 class="font-weight-bold <?= $motorStatusClass ?>" style="font-size: 2.5rem;"><?= $motorStatus ?></h2>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <p class="text-muted"><i class="fas fa-clock mr-2"></i>Last Updated: <strong><?= htmlspecialchars($timestamp) ?></strong></p>
                            <small class="text-muted">Auto-refreshes every 10 seconds</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require("footer.php"); ?>

    <script>
        // Auto-refresh every 10 seconds (less aggressive than 3s)
        setTimeout(function() {
            location.reload();
        }, 10000);
    </script>
</body>
</html>
