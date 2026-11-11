<?php
$logFile = 'log.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['log_text'])) {
    $text = trim($_POST['log_text']);

    if (!empty($text)) {
        $formattedText = "[" . date('Y-m-d H:i:s') . "] " . $text . PHP_EOL;
        file_put_contents($logFile, $formattedText, FILE_APPEND);
        echo "<p>Text saved successfully to $logFile!</p>";
    }
}

// ХЕНДЛЕР 2: Очищення (видалення вмісту) log.txt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_log'])) {
    if (file_exists($logFile)) {
        file_put_contents($logFile, '');
        echo "<p>log.txt has been cleared!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
    <h2>Content of log.txt</h2>

    <?php if (file_exists($logFile) && filesize($logFile) > 0): ?>
        <div>
            <?= nl2br(htmlspecialchars(file_get_contents($logFile))) ?>
        </div>
        <br>
        <form method="POST">
            <button type="submit" name="clear_log">Clear All Logs</button>
        </form>
    <?php else: ?>
        <p>The file log.txt is empty or does not exist yet.</p>
    <?php endif; ?>

    <br>
    <a href="index.html">Back to Home</a>
</html>