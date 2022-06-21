<?php

namespace App\Controller\User;

use App\Entity\Candidature;
use App\Entity\PieceJointe;
use App\Form\ContactType;
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
     * @Route("/utilisateur", name="app_user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/utilisateur/contact", name="utilisateur_contact")
     */
    public function contact(): Response
    {
        return $this->render('user/contact/contact.html.twig', []);
    }

    /**
     * @Route("/utilisateur/contact/email", name="utilisateur_contact_email")
     */
    public function contactEmail(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        return $this->render('user/contact/email.html.twig', [
            "form"=>$form->createView()
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
        // dd($formation);

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
            // dd($candidature);
            $em->flush();

            $this->addFlash(
                'success',
                'Vous avez posuler avec succes a cette formation.nous vous concterons apres selection de dossier'
            );

            return $this->redirectToRoute('formations');
        }

        return $this->render('user/candidature.html.twig', [
            'form' => $form->createView(),
            // 'formation' => $formation
        ]);
    }

    /**
     * @Route("/utilisateur/formations/detail/postuler/{id}", name="user_postule_detail_foramtion")
     */
    public function detailPostuler(Request $request, EntityManagerInterface $em, FormationRepository $formationRepository, $id): Response
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
            // dd($candidature);
            $em->flush();

            $this->addFlash(
                'success',
                'Vous avez posuler avec succes a cette formation.nous vous concterons apres selection de dossier'
            );

            return $this->redirectToRoute('formations');
        }

        return $this->render('user/detailCandidature.html.twig', [
            'form' => $form->createView(),
            // 'formation' => $formation
        ]);
    }
}
