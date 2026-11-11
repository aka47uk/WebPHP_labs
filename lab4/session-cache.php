<?php
session_start();

$cacheLifetime = 60;
$data = null;
$source = "";

if (isset($_SESSION['cached_data']) && isset($_SESSION['cached_time'])) {
    $age = time() - $_SESSION['cached_time'];
    if ($age < $cacheLifetime) {
        $data = $_SESSION['cached_data'];
        $source = "session cache (cache age: {$age} sec)";
    } else {
        // Cache expired
        $data = generateData();
        $_SESSION['cached_data'] = $data;
        $_SESSION['cached_time'] = time();
        $source = "refreshed session cache";
    }
} else {
    // Cache missing
    $data = generateData();
    $_SESSION['cached_data'] = $data;
    $_SESSION['cached_time'] = time();
    $source = "new session cache";
}

function generateData() {
    sleep(2);
    return [
        'USD' => rand(35, 42),
        'EUR' => rand(38, 45),
    ];
}

?>
<!DOCTYPE html>
<html>
    <h3>Exchange Rates</h3>
    <p><strong>Current exchange rate:</strong> <?php echo json_encode($data, JSON_PRETTY_PRINT) ?></p>
    <p><strong>Source:</strong> <?php echo $source ?></p>
    <p><button onclick="location.reload()">Refresh the page</button></p>
    <br>
    <a href="index.html">Back to Home</a>
</html>
