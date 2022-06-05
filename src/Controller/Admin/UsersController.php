<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(UserRepository $userRepo): Response
    {
        return $this->render('users/index.html.twig', [
            'users' => $userRepo->findAll(),
        ]);
    }

    /**
     * @Route("/users/creation", name="creation_users")
     */
    public function creation(Request $request, EntityManagerInterface $em): Response
    {
        $user  = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                "utilisateur" . $user->getNom() . " " . $user->getPrenom() . "a ete creer avec success"
            );
        }
        return $this->render('admin/users/creation.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/users/edition/{id}", name="edition_users")
     */
    public function edition(User $user, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                "utilisateur" . $user->getNom() . " " . $user->getPrenom() . "a ete modifier avec success"
            );
        }
        return $this->render('admin/users/edition.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/users/suppression/{id}", name="suppresion_users")
     */
    public function suppression(User $user, EntityManagerInterface $em): RedirectResponse
    {
            $em->remove($user);
            $em->flush();

            $this->addFlash(
                'success',
                "utilisateur" . $user->getNom() . " " . $user->getPrenom() . "a ete supprimer avec success"
            );
        return $this->render('admin/users/index.html.twig');
    }
}
