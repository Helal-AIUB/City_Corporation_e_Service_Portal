<?php
require_once '../config/db.php';
require_once '../controllers/AuthController.php';

$auth = new AuthController($pdo);
$auth->handleRequest();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Using inline styles for simplicity, you can link your css/style.css -->
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f0f2f5; }
        .container { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 300px; text-align: center; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color:  #2da0a8; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color:  #2da0a8; }
        a { color:  #2da0a8; text-decoration: none; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <p>Enter your email to receive a reset link.</p>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit" name="forgot_password">Send Reset Link</button>
        </form>
        <br>
        <a href="index.php">Back to Login</a>
    </div>
</body>
</html>