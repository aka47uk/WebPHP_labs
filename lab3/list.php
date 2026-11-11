<?php
$uploadDir = 'uploads/';

// ХЕНДЛЕР: Видалення всіх файлів з папки uploads
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_uploads'])) {
    if (is_dir($uploadDir)) {
        $files = array_diff(scandir($uploadDir), ['.', '..']);
        foreach ($files as $file) {
            $filePath = $uploadDir . $file;
            if (is_file($filePath)) {
                unlink($filePath);
            }
        }
        header("Location: list.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .gallery-item {
            border: 1px solid #ccc;
            padding: 20px;
            text-align: center;
            width: 200px;
            background: #f9f9f9;
        }
        .gallery-item img {
            max-width: 100%;
            height: 150px;
            object-fit: cover;
            display: block;
            margin: 0 auto 10px;
        }
    </style>
</head>
<body>
    <h2>Uploaded photo list</h2>

    <?php
    if (is_dir($uploadDir)) {
        $files = array_diff(scandir($uploadDir), ['.', '..']);

        if (!empty($files)) {
            echo "<div class='gallery'>";
            foreach ($files as $file) {
                $filePath = $uploadDir . $file;
                echo "<div class='gallery-item'>";
                echo "<img src='" . htmlspecialchars($filePath) . "' alt='" . htmlspecialchars($file) . "'>";
                echo "<p style='font-size: 16px;'>" . htmlspecialchars($file) . "<br>(" . round(filesize($filePath) / 1024, 2) . " KB)</p>";
                echo "<a href='" . htmlspecialchars($filePath) . "' download>Download</a>";
                echo "</div>";
            }
            echo "</div>";
            ?>
            <br><br>
            <form method="POST">
                <button type="submit" name="clear_uploads">Delete All Uploaded Files</button>
            </form>
            <?php
        } else {
            echo "<p>The uploads directory is empty.</p>";
        }
    } else {
        echo "<p>The uploads directory does not exist.</p>";
    }
    ?>

    <br>
    <br>
    <a href="index.html">Back to Home</a>
</body>
</html>