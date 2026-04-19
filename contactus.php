<?php

session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

// Database Connection
$servername = "localhost";
$username_db = "root";
$password = "";
$dbname = "ecometrics";

$conn = new mysqli($servername, $username_db, $password, $dbname);
if ($conn->connect_error) {
    // Suppress error display for UI purposes or log it
}

// Handle Contact Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contact_submit']) && !$conn->connect_error) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $state = $_POST["state"];
    $city = $_POST["city"];
    $message = $_POST["message"];

    $stmt = $conn->prepare("INSERT INTO contact_us (name, email, phone, state, city, message) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssssss", $name, $email, $phone, $state, $city, $message);
        if ($stmt->execute()) {
            echo "<script>document.addEventListener('DOMContentLoaded', function() { alert('Message Sent Successfully!'); });</script>";
        } else {
            echo "<script>document.addEventListener('DOMContentLoaded', function() { alert('Error sending message!'); });</script>";
        }
        $stmt->close();
    }
}

// Handle Q&A Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['question']) && !$conn->connect_error) {
    $question = $conn->real_escape_string($_POST['question']);
    $stmt = $conn->prepare("INSERT INTO qna (question) VALUES (?)");
    if ($stmt) {
        $stmt->bind_param("s", $question);

        if ($stmt->execute()) {
            echo "<script>document.addEventListener('DOMContentLoaded', function() { alert('Question Submitted!'); });</script>";
        }
        $stmt->close();
    }
}

// Fetch last 4 questions and answers safely
$qna_result = null;
if (!$conn->connect_error) {
    $qna_result = $conn->query("SELECT * FROM qna ORDER BY created_at DESC LIMIT 4");
}
$conn->close();
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
                    <span class="badge-vibrant mb-3 d-inline-block">Get In Touch</span>
                    <h1 class="display-3 text-gradient font-weight-bold">Contact Our Team</h1>
                    <p class="lead mt-3">Have questions or need support? Reach out to us and we'll get back to you shortly.</p>
                </div>
            </div>

            <div class="row row-content mt-5 justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="glass-card mb-4" style="border-top: 5px solid var(--color-primary);">
                        <form action="" method="POST">
                            <h3 class="title text-primary mb-4" style="border-bottom: 2px solid rgba(16, 185, 129, 0.2); padding-bottom: 10px;">Send a Message</h3>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label for="name">Full Name</label>
                                        <input type="text" id="name" name="name" required class="form-control-modern" placeholder="e.g. John Doe">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label for="email">Email Address</label>
                                        <input type="email" id="email" name="email" required class="form-control-modern" placeholder="e.g. john@example.com">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" id="phone" name="phone" required class="form-control-modern" placeholder="e.g. +1 234 567 890">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label for="state">State</label>
                                        <input type="text" id="state" name="state" required class="form-control-modern" placeholder="State">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-modern">
                                        <label for="city">City</label>
                                        <input type="text" id="city" name="city" required class="form-control-modern" placeholder="City">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group-modern">
                                <label for="message">Message</label>
                                <textarea id="message" name="message" required class="form-control-modern" rows="5" placeholder="How can we help you?"></textarea>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" name="contact_submit" class="btn btn-vibrant btn-block btn-lg" style="letter-spacing: 2px;">SEND MESSAGE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Floating Q&A Button -->
    <button id="openQnaBtn" class="btn btn-vibrant shadow-lg" style="position: fixed; bottom: 30px; right: 30px; border-radius: 50px; z-index: 1050; padding: 15px 25px; font-size: 1.1rem;">
        <i class="fas fa-question-circle mr-2"></i> User Q&A
    </button>

    <!-- Q&A Popup Modal (Custom Implementation) -->
    <div id="qnaPopup" class="popup-overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); z-index: 1100; backdrop-filter: blur(5px); align-items: center; justify-content: center;">
        <div class="glass-card popup-content" style="width: 100%; max-width: 500px; position: relative;">
            <button class="close-btn btn btn-sm btn-danger rounded-circle" style="position: absolute; top: 15px; right: 15px; width: 30px; height: 30px; padding: 0; display: flex; align-items: center; justify-content: center;">&times;</button>
            <h3 class="title text-primary"><i class="fas fa-comments mr-2"></i>Community Q&A</h3>
            <p class="text-muted mb-4">Ask a question or view recent queries below.</p>
            
            <form method="POST" class="mb-4">
                <div class="form-group-modern">
                    <textarea name="question" required placeholder="Type your question..." class="form-control-modern" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-vibrant btn-sm w-100">Submit Question</button>
            </form>

            <div class="previous-qa text-left" style="max-height: 250px; overflow-y: auto;">
                <h5 class="font-weight-bold mb-3 border-bottom pb-2">Recent Questions</h5>
                <?php if ($qna_result && $qna_result->num_rows > 0): ?>
                    <?php while ($row = $qna_result->fetch_assoc()) { ?>
                        <div class="qa-item mb-3 p-3 rounded" style="background: rgba(0,0,0,0.03);">
                            <span class="font-weight-bold text-dark d-block">Q: <?= htmlspecialchars($row['question']) ?></span>
                            <span class="text-muted d-block mt-1"><i class="fas fa-reply fa-sm mr-2"></i>A: <?= htmlspecialchars($row['answer'] ?? 'Pending response...') ?></span>
                        </div>
                    <?php } ?>
                <?php else: ?>
                    <p class="text-muted">No questions asked yet or database unavailable.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php require("footer.php");?>

    <script>
        document.getElementById("openQnaBtn").addEventListener("click", function() {
            document.getElementById("qnaPopup").style.display = "flex";
        });
        document.querySelector(".close-btn").addEventListener("click", function() {
            document.getElementById("qnaPopup").style.display = "none";
        });
        
        // Close if clicking outside the modal content
        document.getElementById("qnaPopup").addEventListener("click", function(e) {
            if (e.target === this) {
                this.style.display = "none";
            }
        });
    </script>

</body>
</html>
