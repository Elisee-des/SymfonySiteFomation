<?php

namespace App\Controller\Main;

use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'formation' => $formationRepository->findAll(),
        ]);
    }

    
}
