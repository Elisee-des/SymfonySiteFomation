<?php

namespace App\Controller\Admin;

use App\Entity\Formation;
use App\Entity\User;
use App\Form\FormationType;
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
    public function index(): Response
    {
        return $this->render('admin/formation/index.html.twig', [
            'controller_name' => 'FormationController',
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

            $nomOrigine = $image->getClientOriginalName();

            $imageNom = $formation->getTitre() .".". $image->guessExtension();

            $image->move($this->getParameter("images_directory"), $imageNom);

            
            $formation->setImage($imageNom);
            // dd($imageNom);


            $em->persist($formation);
            $em->flush();

            $this->addFlash(
               'message',
               "la formation".$formation->getTitre()."a ete creer avec success"
            );
            dd($this->getParameter("images_directory"));
            
        }

        return $this->render('admin/formation/edition.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
