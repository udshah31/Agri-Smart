<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

$apiKey = "e5ed40c0e7f9438db7a27a93cb5f0be1";
$newsUrl = "https://newsapi.org/v2/everything?q=agriculture&apiKey=$apiKey";

$newsArticles = [];
$errorMessage = null;

// cURL request to fetch news
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $newsUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'User-Agent: AgriSmart/1.0'
));
$response = curl_exec($ch);
$curlError = curl_error($ch);


if ($curlError) {
    $errorMessage = "Could not fetch news. Network error.";
} else {
    $newsData = json_decode($response, true);
    if ($newsData !== null && isset($newsData['status']) && $newsData['status'] === "ok") {
        $newsArticles = $newsData['articles'] ?? [];
    } else {
        $errorMessage = "News API unavailable. " . ($newsData['message'] ?? 'Please try again later.');
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
                    <span class="badge-vibrant mb-3 d-inline-block">Latest Updates</span>
                    <h1 class="display-3 text-gradient font-weight-bold">Agriculture News</h1>
                    <p class="lead mt-3">Stay updated with the latest trends and news in the agricultural industry.</p>
                </div>
            </div>

            <?php if ($errorMessage): ?>
                <div class="row mt-4 justify-content-center">
                    <div class="col-md-8">
                        <div class="glass-card text-center" style="background: rgba(255, 193, 7, 0.1); border-left: 5px solid #ffc107;">
                            <p class="lead mb-0"><i class="fas fa-exclamation-triangle mr-2 text-warning"></i><?= htmlspecialchars($errorMessage) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($newsArticles)): ?>
                <div class="row mt-5">
                    <?php foreach ($newsArticles as $article): 
                        if (empty($article['title']) || empty($article['url'])) continue;
                        $desc = $article['description'] ?? 'No description available.';
                        if (strlen($desc) > 120) $desc = substr($desc, 0, 120) . '...';
                        $img = $article['urlToImage'] ?? 'assets/img/agri.png';
                    ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="glass-card h-100" style="padding: 0; overflow: hidden;">
                                <img src="<?= htmlspecialchars($img) ?>" alt="News Image" style="width: 100%; height: 200px; object-fit: cover;" onerror="this.src='assets/img/agri.png'">
                                <div style="padding: 20px;">
                                    <h5 class="title font-weight-bold" style="font-size: 1rem; line-height: 1.4; min-height: 44px;"><?= htmlspecialchars($article['title']) ?></h5>
                                    <p class="description mt-2 mb-3" style="font-size: 0.9rem; color: #666;"><?= htmlspecialchars($desc) ?></p>
                                    <a href="<?= htmlspecialchars($article['url']) ?>" target="_blank" class="btn btn-vibrant btn-sm">Read More →</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php elseif (!$errorMessage): ?>
                <div class="row mt-4 justify-content-center">
                    <div class="col-md-8">
                        <div class="glass-card text-center">
                            <p class="lead mb-0">No articles available at this time.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php require("footer.php"); ?>
</body>
</html>