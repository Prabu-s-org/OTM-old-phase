<?php
session_start();

$width = 150;
$height = 60;
$img = imagecreatetruecolor($width, $height);

// Background: Gray
// $bgcolor = imagecolorallocate($img, 128, 128, 128);
// $bgcolor = imagecolorallocate($img, 128, 128, 128); // Medium gray
// $bgcolor = imagecolorallocate($img, 255, 0, 0);
$bgcolor = imagecolorallocate($img, 230, 230, 230); // very light gray


imagefilledrectangle($img, 0, 0, $width, $height, $bgcolor);

// Text color: White
// $text_color = imagecolorallocate($img, 255, 255, 255);
// $text_color = imagecolorallocate($img, 255, 255, 255);
$text_color = imagecolorallocate($img, 0, 0, 0); // black


// Generate CAPTCHA text
$text = generateRandomString();
$_SESSION['captcha_text'] = $text;

// TTF font path
$font_path = __DIR__ . '/arial.ttf';

// Try to fit largest font size possible
$max_font_size = 60;
$min_font_size = 10;
$font_size = $max_font_size;

if (file_exists($font_path)) {
    do {
        $bbox = imagettfbbox($font_size, 0, $font_path, $text);
        $text_width = $bbox[2] - $bbox[0];
        $text_height = $bbox[1] - $bbox[7];
        if ($text_width <= $width - 10 && $text_height <= $height - 10) {
            break;
        }
        $font_size--;
    } while ($font_size >= $min_font_size);

    // Center the text
    $x = ($width - $text_width) / 2;
    $y = ($height + $text_height) / 2;

    imagettftext($img, $font_size, 0, $x, $y, $text_color, $font_path, $text);
} else {
    // Fallback
    imagestring($img, 5, 30, 20, $text, $text_color);
}

// Add noise
$dot_color = imagecolorallocate($img, 180, 180, 180);
for ($i = 0; $i < 100; $i++) {
    imagesetpixel($img, rand(0, $width), rand(0, $height), $dot_color);
}

// Output
header("Content-Type: image/png");
imagepng($img);
imagedestroy($img);

// Generator
function generateRandomString($length = 6) {
    $characters = '0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>
