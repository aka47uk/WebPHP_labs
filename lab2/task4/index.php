<?php
session_start();

$timeout = 60 * 5;

// Check activity time
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    $_SESSION = array();
    session_destroy();
    header("Location: index.php?timeout=1");
    exit();
}
$_SESSION['last_activity'] = time();

$message = '';
if (isset($_GET['timeout'])) {
    $message = "Session expired due to inactivity (5 minutes). Your cart was cleared.";
}

// Cart session initialization
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Read previous purchases cookie
$previous_purchases = json_decode($_COOKIE['previous_purchases'] ?? '[]', true);
if (!is_array($previous_purchases)) {
    $previous_purchases = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add item to cart
    if (isset($_POST['item']) && !empty(trim($_POST['item']))) {
        $item = trim($_POST['item']);

        $_SESSION['cart'][] = $item;

        // Update cookie
        if (!in_array($item, $previous_purchases)) {
            $previous_purchases[] = $item;
            setcookie(
                'previous_purchases',
                json_encode($previous_purchases),
                time() + 60 * 60 * 24 * 7,
                "/"
            );
        }
        header("Location: index.php");
        exit();
    }

    // Cart clear
    if (isset($_POST['clear_cart'])) {
        $_SESSION['cart'] = [];
        header("Location: index.php");
        exit();
    }

    // Cookie clear
    if (isset($_POST['delete_cookie'])) {
        setcookie('previous_purchases', '', time() - 3600, "/");
        unset($_COOKIE['previous_purchases']);
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
    <h2>$_SESSION + $_COOKIE Test (Shopping cart)</h2>

    <?php if ($message): ?>
        <p><?php echo $message ?></p>
    <?php endif; ?>

    <p>Session will expire after 5 minutes of inactivity.</p>

    <form method="POST">
        <label for="item">Add item:</label>
        <input type="text" id="item" name="item" required>
        <br>
        <br>
        <button type="submit">Add to cart</button>
    </form>

    <h3>Current cart ($_SESSION):</h3>
    <?php if (!empty($_SESSION['cart'])): ?>
        <ul>
            <?php foreach ($_SESSION['cart'] as $cartItem): ?>
                <li><?php echo $cartItem ?></li>
            <?php endforeach; ?>
        </ul>
        <form method="POST">
            <button type="submit" name="clear_cart">Clear cart</button>
        </form>
    <?php else: ?>
        <p>Cart is empty.</p>
    <?php endif; ?>

    <hr>

    <h3>Previous purchases ($_COOKIE):</h3>
    <?php if (!empty($previous_purchases)): ?>
        <ul>
            <?php foreach ($previous_purchases as $prevItem): ?>
                <li><?php echo $prevItem ?></li>
            <?php endforeach; ?>
        </ul>
        <form method="POST">
            <button type="submit" name="delete_cookie">Delete cookie</button>
        </form>
    <?php else: ?>
        <p>Purchase history is empty.</p>
    <?php endif; ?>
</html>
