<?php

namespace App\Controller\Main;

use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(FormationRepository $formationRepository, CategorieRepository $categorieRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'formations' => $formationRepository->findAll(),
            "categories" => $categorieRepository->findAll()
        ]);
    }

    
}
