<?php

namespace App\Controller\User;

use App\Form\SMSContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SMSContactController extends AbstractController
{
    /**
     * @Route("/utilisateur/contact", name="utilisateur_contact")
     */
    public function contact(): Response
    {
        return $this->render('user/contact/contact.html.twig', []);
    }

    /**
     * @Route("/utilisateur/contact/sms", name="utilisateur_contact_sms")
     */
    public function contactEmail(Request $request): Response
    {
        /**
         * @var User
         */
        $form = $this->createForm(SMSContactType::class);

        return $this->render('user/contact/sms.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
