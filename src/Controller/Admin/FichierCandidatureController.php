<?php

namespace App\Controller\Admin;

use App\Entity\Formation;
use App\Entity\User;
use App\Form\EditFormationType;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use App\Services\UploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/formations", name="admin_formations_")
 */
class FichierCandidatureController extends AbstractController
{
    /**
     * @Route("/liste", name="liste")
     */
    public function index(FormationRepository $formationRepository): Response
    {

        return $this->render('admin/formation/indexFichier.html.twig', [
            'formations' => $formationRepository->findAll()
        ]);
    }

    /**
     * @Route("/liste/{id}", name="detail")
     */
    public function deatil(Formation $formation): Response
    {
        return $this->render('admin/formation/detail.html.twig', [
            'titre' => $formation->getTitre(),
            'description' => $formation->getDescription(),
            'nombrePlace' => $formation->getNombrePlace(),
            'datePublication' => $formation->getDatePublication(),
            'dateDebutFormation' => $formation->getDateDebutFormation(),
            'dateFinFormation' => $formation->getDateFinFormation(),
            'nomCategorie' => $formation->getCategorie()->getNom(),
            ''
        ]);
    }



    /**
     * @Route("/candidature/suppression/{id}", name="candidature_suppression")
     */
    public function candidatureFichier(FormationRepository $formationRepository, $id): Response
    {
        $formation = $formationRepository->find($id);

        dd($formation);
        $fichiers = $formation->getCandidatures();
        return $this->render("admin/formation/fichiersDetail.html.twig", [
            // 'fichiers' => $fichiers
        ]);
    }

   
}
