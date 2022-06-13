<?php

namespace App\Controller\Admin;

use App\Entity\Candidature;
use App\Entity\PieceJointe;
use App\Form\CandidaturesType;
use App\Repository\CandidatureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/candidature", name="admin_candidature_")
 */
class CandidaturesController extends AbstractController
{
    /**
     * @Route("/liste", name="liste")
     */
    public function index(CandidatureRepository $candidatureRepository): Response
    {
        return $this->render('admin/candidatures/index.html.twig', [
            'candidatures' => $candidatureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/creation", name="creation")
     */
    public function creation(CandidatureRepository $candidatureRepository, Request $request): Response
    {
        $candidature = new Candidature();

        $fichier = new PieceJointe();
        
        $nom = uniqid();
        
        $form = $this->createForm(CandidaturesType::class, $candidature);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            dd($request->files->);

            $fichiers = $form->get('fichiers')->getData();
            
            $nouveauNom = $nom.".".$fichiers->guessExtension();
            
            $fichiers->move($this->getParameter("fichiers_directory"), $nouveauNom);

            dd($nouveauNom);

            $fichier->setFichiers($fichiers);
            
            // $test = $candidature->getPieceJointe()->($fichiers);

            
        }

        return $this->render('admin/candidatures/creation.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
