<?php

namespace App\Controller\Admin;

use App\Entity\Ville;
use App\Form\VilleType;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin", name="admin_")
 */
class VilleController extends AbstractController
{
    /**
     * @Route("/ville", name="ville")
     */
    public function index(VilleRepository $villeRepo): Response
    {
        return $this->render('admin/ville/index.html.twig', [
            'villes' => $villeRepo->findAll(),
        ]);
    }

    /**
     * @Route("/ville/creation", name="creation_ville")
     */
    public function creation(Request $request, EntityManagerInterface $em): Response
    {
        $ville  = new Ville();

        $form = $this->createForm(VilleType::class, $ville);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($ville);
            $em->flush();

            $this->addFlash(
                'success',
                "La ville de " . $ville->getNom() . " a ete creer avec success"
            );
            
            return $this->redirectToRoute('admin_ville');
        }
        return $this->render('admin/ville/creation.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/ville/edition/{id}", name="edition_ville")
     */
    public function edition(Ville $ville, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UserType::class, $ville);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($ville);
            $em->flush();

            $this->addFlash(
                'success',
                "La ville de" . $ville->getNom(). " a ete modifier avec success"
            );
            return $this->redirectToRoute('admin_ville');
        }
        return $this->render('admin/ville/edition.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/ville/suppression/{id}", name="suppresion_ville")
     */
    public function suppression(Ville $user, EntityManagerInterface $em): Response
    {
        $em->remove($user);
        $em->flush();

        $this->addFlash(
            'success',
            "La ville de " . $user->getNom(). " a ete supprimer avec success"
        );
        return $this->redirectToRoute('admin_ville');
    }
}