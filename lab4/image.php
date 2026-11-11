<?php

// image generation
header("Content-Type: image/png");
header("Cache-Control: public, max-age=" . $maxAge = 86400);
header("Expires: " . gmdate("D, d M Y H:i:s", time() + $maxAge)); // expires after 1 day

$image = imagecreate(200, 200);
$bgColor = imagecolorallocate($image, 20, 20, 200);

// image output
imagepng($image);
