<?php
session_start();

// Generate CAPTCHA code
$captchaCode = rand(100000, 999999);
$_SESSION['captcha_code'] = $captchaCode;

// Create CAPTCHA image
$captchaImage = imagecreatetruecolor(100, 40);
$backgroundColor = imagecolorallocate($captchaImage, 255, 255, 255);
$textColor = imagecolorallocate($captchaImage, 0, 0, 0);

imagefilledrectangle($captchaImage, 0, 0, 100, 40, $backgroundColor);
imagestring($captchaImage, 5, 30, 10, $captchaCode, $textColor);

// Output image as PNG
header("Content-type: image/png");
imagepng($captchaImage);
imagedestroy($captchaImage);
?>
