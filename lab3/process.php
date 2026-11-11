<?php
$uploadDir = 'uploads/';

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    if ($file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
        die("Error during file upload.");
    }

    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileTmpPath = $file['tmp_name'];

    $maxSize = 2 * 1024 * 1024;
    if ($fileSize > $maxSize) {
        die("Error: File size exceeds the 2 MB limit!");
    }

    $allowedExtensions = ['png', 'jpg', 'jpeg'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) {
        die("Error: Only image files (PNG, JPG, JPEG) are allowed!");
    }

    $destination = $uploadDir . $fileName;
    if (file_exists($destination)) {
        $fileBaseName = pathinfo($fileName, PATHINFO_FILENAME);
        $newFileName = $fileBaseName . '-' . rand(1, 999) . '.' . $fileExtension;
        $destination = $uploadDir . $newFileName;
        echo "<p>A file with this name already existed. Saved under a new name: <strong>" . htmlspecialchars($newFileName) . "</strong></p>";
    } else {
        $newFileName = $fileName;
    }

    if (move_uploaded_file($fileTmpPath, $destination)) {
        echo "<h3>File uploaded successfully!</h3>";
        echo "<ul>";
        echo "<li><strong>Original Name:</strong> " . htmlspecialchars($fileName) . "</li>";
        echo "<li><strong>File Type:</strong> " . $fileExtension . "</li>";
        echo "<li><strong>File Size:</strong> " . round($fileSize / 1024, 2) . " KB</li>";
        echo "</ul>";
        echo "<a href='" . htmlspecialchars($destination) . "' download>Download file</a>";
    } else {
        echo "Error saving the file on the server.";
    }
} else {
    header("Location: index.html");
    exit();
}
?>
<br>
<br>
<a href="index.html">Back to Home</a>
