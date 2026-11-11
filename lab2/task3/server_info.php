<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: get_method.php");
    exit();
}

$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$script_name = $_SERVER['PHP_SELF'];
$request_method = $_SERVER['REQUEST_METHOD'];
$file_path = $_SERVER['SCRIPT_FILENAME']
?>
<!DOCTYPE html>
    <h2>Request and server information</h2>
    <ul>
        <li><strong>Client IP-address:</strong> <?php echo $ip_address ?></li>
        <li><strong>Browser (User Agent):</strong> <?php echo $user_agent ?></li>
        <li><strong>Script name:</strong> <?php echo $script_name ?></li>
        <li><strong>Request method:</strong> <?php echo $request_method ?></li>
        <li><strong>File path on server:</strong> <?php echo $file_path ?></li>
    </ul>

    <a href="index.php">Return to main page</a>
</html>
