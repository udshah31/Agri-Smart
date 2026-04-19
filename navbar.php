<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>
<nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-light position-sticky top-0 shadow py-2" style="z-index: 10000; background: rgba(255,255,255,0.92); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">
  <div class="container-fluid">
    <a href="index.php" class="navbar-brand mr-lg-5 text-dark" style="font-family: var(--font-heading); font-weight: 800; font-size: 1.5rem; letter-spacing: -0.5px;">
      <i class="fas fa-leaf" style="color: var(--color-primary);"></i> AgriSmart
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation" style="border: none;">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="navbar_global">
      <ul class="navbar-nav align-items-lg-center ml-auto topnav" id="nav">
        
        <li class="nav-item">
          <a class="nav-link text-dark font-weight-bold" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark font-weight-bold" href="aboutus.php">About Us</a>
        </li>

        <!-- Prediction Dropdown — NO Bootstrap dropdown classes used -->
        <li class="nav-item agri-dd" style="position: relative;">
          <a class="nav-link text-dark font-weight-bold agri-dd-toggle" href="javascript:void(0)">
            <i class="fas fa-magic text-primary"></i> Prediction
          </a>
          <div class="agri-dd-menu">
            <a href="crop_prediction.php">Crop Prediction</a>
            <a href="yield_prediction.php">Yield Prediction</a>
            <a href="rainfall_prediction.php">Rainfall Prediction</a>
          </div>
        </li>

        <!-- Recommendation Dropdown -->
        <li class="nav-item agri-dd" style="position: relative;">
          <a class="nav-link text-dark font-weight-bold agri-dd-toggle" href="javascript:void(0)">
            <i class="fas fa-gavel text-primary"></i> Recommendation
          </a>
          <div class="agri-dd-menu">
            <a href="crop_recommendation.php">Crop Recommendation</a>
            <a href="fertilizer_recommendation.php">Fertilizer Recommendation</a>
          </div>
        </li>

        <!-- Services Dropdown -->
        <li class="nav-item agri-dd" style="position: relative;">
          <a class="nav-link text-dark font-weight-bold agri-dd-toggle" href="javascript:void(0)">
            <i class="fas fa-seedling text-primary"></i> Services
          </a>
          <div class="agri-dd-menu">
            <a href="soil_health.php">Soil Health</a>
            <a href="waste-mgt.php">Waste Management</a>
            <a href="smart-irrigation.php">Smart Irrigation</a>
            <a href="newspaper.php">Agriculture News</a>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link text-dark font-weight-bold" href="contactus.php">Contact</a>
        </li>

        <li class="nav-item ml-lg-4">
          <?php if($username !== 'Guest'): ?>
            <div class="agri-dd" style="position: relative; display: inline-block;">
              <button class="btn btn-vibrant px-4 text-white agri-dd-toggle" type="button" style="border-radius: 50px;">
                <i class="fas fa-user-circle mr-2"></i> <?php echo htmlspecialchars($username); ?>
              </button>
              <div class="agri-dd-menu" style="right: 0; left: auto;">
                <a href="dashboard.php"><i class="fas fa-tachometer-alt mr-2 text-primary"></i> Dashboard</a>
                <hr style="margin: 4px 0; border-color: #eee;">
                <a href="logout.php" style="color: #e74c3c;"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
              </div>
            </div>
          <?php else: ?>
            <a href="login.php" class="btn btn-vibrant px-4 text-white" style="border-radius: 50px;">
              <i class="fas fa-sign-in-alt mr-2"></i> Login
            </a>
          <?php endif; ?>
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
/* Nav link underline animation */
.topnav .nav-link {
  transition: all 0.3s ease;
  position: relative;
}
.topnav .nav-link::after {
  content: '';
  position: absolute;
  width: 0;
  height: 2px;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  background-color: var(--color-primary);
  transition: width 0.3s ease;
}
.topnav .nav-link:hover::after, .topnav .nav-link.activaa::after {
  width: 80%;
}

/* ===== CUSTOM DROPDOWN (fully independent of Bootstrap) ===== */
.agri-dd-menu {
  display: none;
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 999999;
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 10px 40px rgba(0,0,0,0.15);
  padding: 8px 0;
  min-width: 220px;
  border: 1px solid rgba(0,0,0,0.06);
}

.agri-dd.open > .agri-dd-menu {
  display: block;
}

.agri-dd-menu a {
  display: block;
  padding: 10px 20px;
  color: #333;
  text-decoration: none;
  font-size: 0.95rem;
  font-weight: 500;
  transition: all 0.15s ease;
  border-radius: 8px;
  margin: 2px 6px;
}

.agri-dd-menu a:hover {
  background-color: rgba(16, 185, 129, 0.12);
  color: var(--color-primary-dark);
}
/* ============================================================ */
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {

    // Active link highlighting
    var currentUrl = window.location.href;
    document.querySelectorAll("#nav li a.nav-link").forEach(function(link) {
        if (link.href === currentUrl) {
            link.classList.add("activaa");
        }
    });

    // === CUSTOM DROPDOWN LOGIC (zero Bootstrap dependency) ===
    var dropdowns = document.querySelectorAll('#navbar-main .agri-dd');
    
    dropdowns.forEach(function(dd) {
        var closeTimer = null;

        function openDD() {
            // Close all others
            dropdowns.forEach(function(d) { d.classList.remove('open'); });
            if (closeTimer) clearTimeout(closeTimer);
            dd.classList.add('open');
        }

        function closeDD() {
            closeTimer = setTimeout(function() {
                dd.classList.remove('open');
            }, 400); // 400ms grace period — plenty of time to move mouse
        }

        function keepOpen() {
            if (closeTimer) clearTimeout(closeTimer);
        }

        // Hover: open/close with delay
        dd.addEventListener('mouseenter', function() {
            keepOpen();
            openDD();
        });
        dd.addEventListener('mouseleave', closeDD);

        // Click toggle (works on mobile AND desktop as fallback)
        var toggle = dd.querySelector('.agri-dd-toggle');
        if (toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (dd.classList.contains('open')) {
                    dd.classList.remove('open');
                } else {
                    openDD();
                }
            });
        }
    });

    // Close all when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.agri-dd')) {
            dropdowns.forEach(function(d) { d.classList.remove('open'); });
        }
    });
});
</script>
