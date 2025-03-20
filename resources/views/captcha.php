<?php
session_start();
$captcha = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
$_SESSION["captcha"] = $captcha;

$image = imagecreatetruecolor(120, 40);
$bgColor = imagecolorallocate($image, 200, 200, 200);
$textColor = imagecolorallocate($image, 0, 0, 0);

imagefill($image, 0, 0, $bgColor);
imagestring($image, 5, 30, 12, $captcha, $textColor);

header("Content-type: image/png");
imagepng($image);
imagedestroy($image);
?>