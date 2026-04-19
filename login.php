<?php
session_start(); // Start the session
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: dashboard.php");
    exit();
}
// Include database connection
include('db.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if admin login
    if ($username === "admin" && $password === "admin") {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = "admin";
        header("Location: admin.php");
        exit();
    }

    // Prepare and execute query to check user credentials
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    // Check if user exists and verify password
    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

        // Redirect to the dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sustainability & Climate Change</title>

    <link rel="stylesheet" href="styles.css">
</head>
<body class="auth-bg">
    <div class="auth-container">
        <div class="glass-card text-center">
            <h2 class="mb-4 text-gradient">Welcome Back</h2>
            
            <?php if (isset($error)) { echo "<p style='color: red;' class='mb-3'>$error</p>"; } ?>
            
            <form method="POST" action="" class="text-left">
                <div class="form-group-modern">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control-modern" required>
                </div>
                
                <div class="form-group-modern">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control-modern" required>
                </div>
                
                <button type="submit" class="btn-vibrant w-100 mt-2">Login</button>
            </form>
            
            <p class="mt-4">Don't have an account? <a href="signup.php" style="color: var(--color-primary); font-weight: 600;">Sign up here</a></p>
        </div>
    </div>
</body>
</html>
