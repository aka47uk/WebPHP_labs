<?php
session_start();
require_once 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        $error = "Fill in all fields!";
    } else {
        // Check if username and email are unique
        $checkStmt = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
        $checkStmt->execute(['username' => $username, 'email' => $email]);
        
        if ($checkStmt->fetch()) {
            $error = "User with this username or email already exist!";
        } else {
            // Hashing password
            $hashedPassword = md5($password);

            $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashedPassword])) {
                $success = "Registration completed! Now you can <a href='login.php'>log in</a>.";
            } else {
                $error = "Error while data saving.";
            }
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
        input[type="text"], input[type="password"], input[type="email"] { width: 100%; padding: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; border: 1px solid #000000; font-size: 16px; border-radius: 4px; cursor: pointer; }
        button:hover { background: #e6e6e6; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="form-card">
    <h2 style="text-align: center;">Registration</h2>
    <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="success"><?= $success ?></div><?php endif; ?>

    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Register</button>
    </form>
    <p style="margin-top: 15px; text-align: center;">Have an account? <a href="login.php">Login here</a></p>
</div>

</body>
</html>
