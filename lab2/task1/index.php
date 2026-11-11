<?php
// Check if form was sent
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && !empty(trim($_POST['username']))) {
        $name = trim($_POST['username']);
        setcookie(
            'username',
            $name,
            time() + 60 * 60 * 24 * 7,
            "/"
        );
        header("Location: index.php");
        exit();
    }

    // Delete cookie
    if (isset($_POST['delete_cookie'])) {
        setcookie('username', '', time() - 3600, "/");
        unset($_COOKIE['username']);
        header("Location: index.php");
        exit();
    }
}

$savedName = $_COOKIE['username'] ?? null;
?>
<!DOCTYPE html>
<html>
    <h2>$_COOKIE Test</h2>
    <?php if ($savedName): ?>
        <h3>Hello, <?php echo $savedName ?>!</h3>
        <form method="POST">
            <button type="submit" name="delete_cookie">Delete cookie</button>
        </form>
    <?php else: ?>
        <form method="POST">
            <label for="username">Enter your name:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <br>
            <button type="submit">Save</button>
        </form>
    <?php endif; ?>
</html>
