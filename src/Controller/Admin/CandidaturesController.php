<?php

namespace App\Controller\Admin;

use App\Entity\Candidature;
use App\Form\CandidatureType;
use App\Form\EditCandidaturesType;
use App\Form\EditCandidatureType;
use App\Repository\CandidatureRepository;
use App\Services\UploaderFichiers;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/liste/", name="liste")
     */
    public function index(CandidatureRepository $candidatureRepository): Response
    {

        return $this->render('admin/candidatures/index.html.twig', [
            'candidatures' => $candidatureRepository->findAll(["id" => "DESC"]),
        ]);
    }

    /**
     * @Route("/creation", name="creation")
     */
    public function creation(EntityManagerInterface $em, Request $request, UploaderFichiers $uploader): Response
    {
        $candidature = new Candidature();

        $nom = uniqid();

        $form = $this->createForm(CandidatureType::class, $candidature);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $cv = $request->files->get("candidature")["cv"];
            $diplome = $request->files->get("candidature")["diplome"];
            $lettreMotivation = $request->files->get("candidature")["lettre_motivation"];
            $photo = $request->files->get("candidature")["photo"];
            
            $nomNouveauCv = $uploader->upload($cv);
            $nomNouveauDiplome = $uploader->upload($diplome);
            $nomNouveauLettreMotivation = $uploader->upload($lettreMotivation);
            $nomNouveauPhoto = $uploader->upload($photo);

            $candidature->setCv($nomNouveauCv);
            $candidature->setDiplome($nomNouveauDiplome);
            $candidature->setLettreMotivation($nomNouveauLettreMotivation);
            $candidature->setPhoto($nomNouveauPhoto);

            $em->persist($candidature);
            $em->flush();

            return $this->redirectToRoute('admin_candidature_liste');

            $this->addFlash(
                'success',
                "la candidature" . $candidature->getId() . " a ete ajouter avec success"
            );
        }

        return $this->render('admin/candidatures/creation.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edition/{id}", name="edition")
     */
    public function edition(Candidature $candidature, EntityManagerInterface $em, Request $request, UploaderFichiers $uploader): Response
    {
        // dd($candidature);
        $form = $this->createForm(EditCandidatureType::class, $candidature);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
             
            $cv = $request->files->get("edit_candidature")["cv"];
            $diplome = $request->files->get("edit_candidature")["diplome"];
            $lettreMotivation = $request->files->get("edit_candidature")["lettre_motivation"];
            $photo = $request->files->get("edit_candidature")["photo"];
            
            $nomNouveauCv = $uploader->upload($cv);
            $nomNouveauDiplome = $uploader->upload($diplome);
            $nomNouveauLettreMotivation = $uploader->upload($lettreMotivation);
            $nomNouveauPhoto = $uploader->upload($photo);

            $candidature->setCv($nomNouveauCv);
            $candidature->setDiplome($nomNouveauDiplome);
            $candidature->setLettreMotivation($nomNouveauLettreMotivation);
            $candidature->setPhoto($nomNouveauPhoto);

            $em->persist($candidature);
            $em->flush();

            return $this->redirectToRoute('admin_candidature_liste');

            $this->addFlash(
                'success',
                "la candidature" . $candidature->getId() . " a ete modifier avec success"
            );
        }

        return $this->render('admin/candidatures/edition.html.twig', [
            'form' => $form->createView(),
            "nomCandidature"=>$candidature->getNom()
        ]);
    }

    /**
     * @Route("/suppresion/{id}", name="suppression")
     */
    public function suppression(Candidature $candidature, EntityManagerInterface $em, Request $request): Response
    {
       
            $em->remove($candidature);
            $em->flush();

            return $this->redirectToRoute('admin_candidature_liste');

            $this->addFlash(
                'success',
                "la candidature" . $candidature->getId() . " a ete suppreimé avec success"
            );
    }
}
