<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TasseController extends AbstractController
{
    #[Route('/tasse', name: 'app_tasse')]
    public function index(): Response
    {
        return $this->render('tasse/index.html.twig', [
            'controller_name' => 'TasseController',
        ]);
    }

    #[Route('/tasse/ajouter', name: 'app_tasse_ajout')]
    public function ajouter(): Response
    {
        return $this->render('tasse/ajouter.html.twig', [
            'controller_name' => 'TasseController',
        ]);
    }
}
