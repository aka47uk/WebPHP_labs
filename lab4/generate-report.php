<?php
$cacheDir = __DIR__ . '/cache';
$cacheFile = $cacheDir . '/report.html';
$cacheTime = 600;

// delete report
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    if (file_exists($cacheFile)) {
        unlink($cacheFile);
    }
    header("Location: index.html");
    exit;
}

// Create directory
if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0777, true);
}

// if file exists and file existing for less than 10 minutes
if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTime)) {
    readfile($cacheFile);
    exit;
}

sleep(3);
$names = ['Natalia', 'Andrii', 'Robert', 'Volodymyr', 'Mykola', 'Oksana'];

ob_start(); // Output buffering
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        table { border-collapse: collapse; width: 50%; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: center; }
    </style>
</head>
<body>
    <h2>Report (Generated: <?= date("d-m-Y H:i:s") ?>)</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Sum ($)</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 1; $i <= 1000; $i++): ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $names[array_rand($names)] ?></td>
                    <td><?= rand(100, 5000) ?></td>
                    <td><?= date("d-m-Y", strtotime("-" . rand(0, 365) . " days")) ?></td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</body>
</html>
<?php
$htmlContent = ob_get_clean();

// Save report
file_put_contents($cacheFile, $htmlContent);

// Output report
echo $htmlContent;
