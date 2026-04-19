<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

// Database Connection
$servername = "localhost";
$db_username = "root";
$password = "";
$dbname = "ecometrics";

$conn = new mysqli($servername, $db_username, $password, $dbname);

$dustbins = [];

if (!$conn->connect_error) {
    $sql_all = "SELECT * FROM waste_mgt ORDER BY id DESC LIMIT 1";
    $result_all = $conn->query($sql_all);

    if ($result_all && $result_all->num_rows > 0) {
        $row = $result_all->fetch_assoc();
        for ($i = 1; $i <= 10; $i++) {
            $dustbins["Dustbin $i"] = $row["dust$i"] ?? 0;
        }
    }
    $conn->close();
} else {
    // Demo data when DB not available
    for ($i = 1; $i <= 10; $i++) {
        $dustbins["Dustbin $i"] = rand(0, 1);
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
                    <h1 class="display-3 text-gradient font-weight-bold">🗑️ Waste Management System</h1>
                    <p class="lead mt-3">Track dustbin fill levels in real-time across all monitored locations.</p>
                </div>
            </div>

            <div class="row row-content mt-5 justify-content-center">
                <?php foreach ($dustbins as $dustbinName => $status): 
                    $isFull = $status ? true : false;
                    $statusText = $isFull ? 'Full' : 'Empty';
                    $statusColor = $isFull ? '#e74c3c' : 'var(--color-primary)';
                    $statusBg = $isFull ? 'rgba(231, 76, 60, 0.1)' : 'rgba(16, 185, 129, 0.1)';
                    $statusBorder = $isFull ? 'rgba(231, 76, 60, 0.3)' : 'rgba(16, 185, 129, 0.3)';
                    $icon = $isFull ? 'fas fa-exclamation-triangle' : 'fas fa-check-circle';
                ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="glass-card text-center h-100" style="background: <?= $statusBg ?>; border: 2px solid <?= $statusBorder ?>; padding: 25px 15px;">
                            <div style="font-size: 3rem; margin-bottom: 10px;">🗑️</div>
                            <h5 class="font-weight-bold mb-2"><?= htmlspecialchars($dustbinName) ?></h5>
                            <p class="mb-0">
                                <i class="<?= $icon ?> mr-1" style="color: <?= $statusColor ?>;"></i>
                                <span class="font-weight-bold" style="color: <?= $statusColor ?>; font-size: 1.2rem;"><?= $statusText ?></span>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="row justify-content-center mt-3">
                <div class="col-md-6 text-center">
                    <p class="text-muted"><i class="fas fa-clock mr-2"></i>Auto-refreshes every 5 seconds</p>
                </div>
            </div>
        </div>
    </section>

    <?php require("footer.php"); ?>

    <script>
        setTimeout(function() { location.reload(); }, 5000);
    </script>
</body>
</html>
