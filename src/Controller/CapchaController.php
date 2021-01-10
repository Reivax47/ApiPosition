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
        $phrase = "toto";
        imagefill($image, 0, 0, $white);
        imagettftext($image, 20, 0, 10, 24, $black, __DIR__ . '/font.ttf', $phrase);
        header('Content-type: image/png');
        return imagepng($image);

    }
}
