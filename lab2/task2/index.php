<?php
session_start();

// User
$right_user = 'admin';
$right_password = 'adminpassword404';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($login === $right_user && $password === $right_password) {

        //Write login into SESSION array
        $_SESSION['user'] = $login;

        header("Location: index.php");
        exit();
    } else {
        $error = "Wrong username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
    <h2>$_SESSION Test</h2>

    <?php if (isset($_SESSION['user'])): ?>
        <p>Hello, <?php echo $_SESSION['user'] ?>!</p>
        <a href="logout.php"><button>Exit</button></a>
    <?php else: ?>

        <?php if ($error): ?>
            <p><?php echo $error ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Username:</label>
            <input type="text" name="login" required>

            <br>
            <br>

            <label>Password:</label>
            <input type="password" name="password" required>

            <br>
            <br>

            <button type="submit">Log in</button>
        </form>

    <?php endif; ?>
</html>
