<?php
session_start(); // Start the session

// Include the database connection
include('db.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if username already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        if ($stmt->fetch()) {
            $error = "Username already taken!";
        } else {
            // Insert new user into the database
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            try {
                $stmt->execute(['username' => $username, 'password' => $hashed_password]);
                // Redirect to login page after successful signup
                header("Location: login.php");
                exit();
            } catch (PDOException $e) {
                $error = "Error: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Sustainability & Climate Change</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="auth-bg">
    <div class="auth-container">
        <div class="glass-card text-center">
            <h2 class="mb-4 text-gradient">Create Account</h2>
            
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
                
                <div class="form-group-modern">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control-modern" required>
                </div>
                
                <button type="submit" class="btn-vibrant w-100 mt-2">Sign Up</button>
            </form>
            
            <p class="mt-4">Already have an account? <a href="login.php" style="color: var(--color-primary); font-weight: 600;">Login here</a></p>
        </div>
    </div>
</body>
</html>
