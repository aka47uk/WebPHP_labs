<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Fill in username and password!";
    } else {
        // Search user by username
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        // Check if user exist and if password is correct
        if ($user && $user['password'] === md5($password)) {
            // Save data in SESSION
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            header("Location: welcome.php");
            exit;
        } else {
            $error = "Wrong username or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .form-card { padding: 50px; max-width: 400px; margin: auto; border-radius: 2px; border: 2px solid #000000;}
        .form-group { margin-bottom: 15px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; border: 1px solid #000000; font-size: 16px; border-radius: 4px; cursor: pointer; }
        button:hover { background: #e6e6e6; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="form-card">
    <h2 style="text-align: center;">Log in</h2>
    <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
    <p style="margin-top: 15px; text-align: center;">No account? <a href="register.php">Register here</a></p>
</div>

</body>
</html>
