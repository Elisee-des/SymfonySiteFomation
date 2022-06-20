<?php

namespace App\Controller\User;

use App\Entity\Candidature;
use App\Entity\PieceJointe;
use App\Form\PostuleFormationType;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="app_user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/utilisateur/formations/postuler/{id}", name="user_postule_foramtion")
     */
    public function postul(Request $request, EntityManagerInterface $em, FormationRepository $formationRepository, $id): Response
    {
        $candidature = new Candidature();
        $fichiers = new PieceJointe();
        $formation = $formationRepository->find($id);
        $form = $this->createForm(PostuleFormationType::class, $candidature);

        $user = $this->getUser();
        $candidature->setUser($user);
        $candidature->setFormation($formation);
        $form->handleRequest($request);
        $nom = md5(uniqid());

        if ($form->isSubmitted() && $form->isValid()) {
            $nomFichiers =  $request->files->get("postule_formation")["fichiers"];

            foreach ($nomFichiers as $nomFichier) {
                $nouveauNom = $nom . "." . $nomFichier->guessExtension();

                $nomFichier->move($this->getParameter("images_directory"), $nouveauNom);
            }

            $fichiers->setFichiers($nouveauNom);
            $fichiers->setCandidature($candidature);

            $em->persist($fichiers);
            $em->persist($candidature);
            
            $em->flush();

            $this->addFlash(
                'success',
                'Vous avez posuler avec succes a cette formation.Nous vous concterons apres selection de dossier'
            );

            return $this->redirectToRoute('formations');
        }

        return $this->render('user/candidature.html.twig', [
            'form' => $form->createView(),
            // 'titre' => $formation->getTitre()
        ]);
    }
}
