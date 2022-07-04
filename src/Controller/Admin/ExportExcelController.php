<?php

namespace App\Controller\Admin;

use App\Repository\CandidatureRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExportExcelController extends AbstractController
{

    /**
     * @Route("/admin/formation/listing", name="admin_formation_listing")
     */
    public function index(FormationRepository $formationRepository): Response
    {

        return $this->render('admin/formation/indexExportation.html.twig', [
            'formations' => $formationRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin/formation/retenue/{id}", name="admin_formation_retenu")
     */
    public function candidature($id, FormationRepository $formationRepository): Response
    {
        $formation = $formationRepository->find($id);
        $retenues = $formation->getCandidatures();

        return $this->render('admin/formation/retenuCandidature.html.twig', [
            'titre' => $formation->getTitre(),
            'retenues' => $retenues,
        ]);
    }

    /**
     * @Route("/admin/exportation", name="admin_excel")
     */
    public function exportation(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
