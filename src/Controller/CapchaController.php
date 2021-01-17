<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CapchaController extends AbstractController
{
    /**
     * @Route("/capcha", name="capcha")
     */
    public function index(): Response
    {
        // Start the session
        session_start();
        $image = imagecreatetruecolor(100, 30);
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);
        $phrase = '';
        $longueur = 5;
        $listeCar = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = mb_strlen($listeCar, '8bit') - 1;
        for ($i = 0; $i < $longueur; ++$i) {
            $phrase .= $listeCar[random_int(0, $max)];
        }
        $_SESSION["chaine"] = $phrase;
        $fontFile = $_SERVER["DOCUMENT_ROOT"] . "/font.ttf";
        imagefill($image, 0, 0, $white);
        imagettftext($image, 20, 0, 10, 24, $black, $fontFile, $phrase);
        header('Content-type: image/png');
        return imagepng($image);

    }

}
