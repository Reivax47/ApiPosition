<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/ouestxav", name="accueil")
     */
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    /**
     * @Route("/pluton", name="pluton")
     */
    public function pluton(): Response
    {
        return $this->render('accueil/pluton.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
    /**
     * @Route("/mars", name="mars")
     */
    public function mars(): Response
    {
        return $this->render('accueil/mars.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }


    /**
     * @Route("/senit", name="senit", methods={"POST"})
     */
    public function senit(HubInterface $publisher): Response
    {
        if( $_POST['num']) {


            $valeur = $_POST['num'];

            $update = new Update("http://127.0.0.1:8001/ping",json_encode([$valeur]));
            $publisher->publish($update);
        }


        return $this->render('accueil/mars.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
}
