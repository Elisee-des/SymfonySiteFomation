<?php

namespace App\Controller\User;

use App\Entity\Candidature;
use App\Entity\PieceJointe;
use App\Form\ContactType;
use App\Form\EditPasswordUserType;
use App\Form\EditPhotoUserType;
use App\Form\ModificaionProfilType;
use App\Form\ModificationProfilType;
use App\Form\PostuleFormationType;
use App\Repository\CandidatureRepository;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
     * @Route("/utilisateur/parametre", name="utlisateur_parametre")
     */
    public function parametre(): Response
    {
        return $this->render('user/parametre/index.html.twig', []);
    }

    /**
     * @Route("/utilisateur/parametre/edite-profil", name="utilisateur_edit_profil_parametre")
     */
    public function editProfil(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ModificationProfilType::class, $user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $em->persist($user);
            $em->flush();

            $this->addFlash(
               'message',
               'Vous avez modifier avec succes votre profil'
            );

            return $this->redirectToRoute('utlisateur_parametre');
        }

        return $this->render('user/parametre/editProfil.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/utilisateur/parametre/edite-photo", name="utilisateur_edit_photo_parametre")
     */
    public function editImage(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(EditPhotoUserType::class, $user);

        $form->handleRequest($request);

        $nom = uniqid();
        
        if ($form->isSubmitted() && $form->isValid()) { 

            $photo = $request->files->get("edit_photo_user")["photoProfil"];

            $nouveauNom = $nom.'.'.$photo->guessExtension();

            
            $photo->move($this->getParameter('images_directory'), $nouveauNom);
            // dd($photo);
            
            $em->persist($user);
            $em->flush();

            $this->addFlash(
               'message',
               'Vous avez modifier avec succes votre photo de profil'
            );

            return $this->redirectToRoute('utlisateur_parametre');
        }

        return $this->render('user/parametre/editPhoto.html.twig', [
            "form" => $form->createView()
        ]);

    }

    /**
     * @Route("/utilisateur/parametre/edite-password", name="utilisateur_edit_password_parametre")
     */
    public function editPassword(Request $request, UserPasswordHasherInterface $hashpassword, EntityManagerInterface $em): Response
    {
        /**
         * @var User
        */
        $user = $this->getUser();
        $form = $this->createForm(EditPasswordUserType::class, $user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $request->get("edit_password_user")["password"]["first"];
            $passwordHash = $hashpassword->hashPassword($user, $password);
            $user->setPassword($passwordHash);

            $em->flush();

            $this->addFlash(
               'message',
               'Vous avez modifier avec succes votre mot de passe'
            );

            return $this->redirectToRoute('utlisateur_parametre');
        }

        return $this->render('user/parametre/editPassword.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
