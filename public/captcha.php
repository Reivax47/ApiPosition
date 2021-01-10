<?php
// Start the session
session_start();


function genererChaineAleatoire($longueur, $listeCar = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $chaine = '';
    $max = mb_strlen($listeCar, '8bit') - 1;
    for ($i = 0; $i < $longueur; ++$i) {
        $chaine .= $listeCar[random_int(0, $max)];
    }
    $_SESSION["chaine"] = $chaine;
    return $chaine;
}

$image = imagecreatetruecolor(100, 30);
$black = imagecolorallocate($image, 0, 0, 0);
$white = imagecolorallocate($image, 255, 255, 255);
$phrase = genererChaineAleatoire(5);
imagefill($image, 0, 0, $white);
imagettftext($image, 20, 0, 10, 24, $black, __DIR__ . '/font.ttf', $phrase);

header('Content-type: image/png');
return imagepng($image);
