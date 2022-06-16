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

    /**
     * @Route("/formation", name="formation")
     */
    public function formation(FormationRepository $formationRepository, CategorieRepository $categorieRepository): Response
    {
        return $this->render('main/formation.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/formation/{id}", name="detail_formation")
     */
    public function detailFormation($id, FormationRepository $formationRepository): Response
    {
        $formation = $formationRepository->find($id);

        $titre = $formation->getTitre();
        $description = $formation->getDescription();
        $nombrePlace = $formation->getNombrePlace();
        $dateDebutFormation = $formation->getDateDebutFormation();
        $dateFinFormation = $formation->getDateFinFormation();
        $datePublication = $formation->getDatePublication();

        return $this->render('main/detailFormation.html.twig', [
            "formation"=>$formation,
            "titre"=>$titre,
            "description"=>$description,
            "nombrePlace"=>$nombrePlace,
            "dateDebutFormation"=>$dateDebutFormation,
            "dateFinFormation"=>$dateFinFormation,
            "datePublication"=>$datePublication
        ]);
    }
}
