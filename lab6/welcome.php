<?php
session_start();

// Check if user exist
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .welcome-card { padding: 50px; max-width: 400px; margin: auto; border-radius: 2px; border: 2px solid #000000; text-align: center;}
        .btn-logout { display: inline-block; margin-top: 20px; padding: 10px 20px; text-decoration: none; color: #000000; border-radius: 4px; border: 1px solid #000000;}
        .btn-logout:hover { background: #e6e6e6; }
    </style>
</head>
<body>

<div class="welcome-card">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
    <p>You successfully entered the system.</p>
    <p>Your Email: <strong><?= htmlspecialchars($_SESSION['email']) ?></strong></p>
    <a href="logout.php" class="btn-logout">Log out</a>
</div>

</body>
</html>
