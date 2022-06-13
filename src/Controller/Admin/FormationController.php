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
 * @Route("/admin/formation", name="admin_formation_")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/liste", name="liste")
     */
    public function index(FormationRepository $formationRepository): Response
    {
        
        return $this->render('admin/formation/index.html.twig', [
            'formations' => $formationRepository->findAll()
        ]);
    }

    /**
     * @Route("/creation", name="creation")
     */
    public function creation(Request $request, EntityManagerInterface $em): Response
    {
        $formation = new Formation();

        $form = $this->createForm(FormationType::class, $formation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get("photoFile")->getData();

            $nom = uniqid();

            $imageNom = $nom . "." . $image->guessExtension();

            $image->move($this->getParameter("images_directory"), $imageNom);

            $formation->setImage($imageNom);

            $em->persist($formation);
            $em->flush();

            $this->addFlash(
                'message',
                "la formation" . $formation->getTitre() . "a ete creer avec success"
            );

            return $this->redirectToRoute('admin_formation_liste');
        }

        return $this->render('admin/formation/creation.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edition/{id}", name="edition")
     */
    public function edition(Request $request, Formation $formation, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(EditFormationType::class, $formation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get("photoFile")->getData();

            $nom = uniqid();

            $imageNom = $nom . "." . $image->guessExtension();

            $image->move($this->getParameter("images_directory"), $imageNom);

            $formation->setImage($imageNom);

            $em->persist($formation);
            $em->flush();

            $this->addFlash(
                'message',
                "la formation" . $formation->getTitre() . "a ete modifier avec success"
            );

            return $this->redirectToRoute('admin_formation_liste');
        }

        return $this->render('admin/formation/edition.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/suppression/{id}", name="suppression")
     */
    public function suppresion(Request $request, Formation $formation, EntityManagerInterface $em): Response
    {
        $em->remove($formation);
        $em->flush();

        $this->addFlash(
            'message',
            "la formation" . $formation->getTitre() . "a ete supprimer avec success"
        );

        return $this->redirectToRoute('admin_formation_liste');
    }
}