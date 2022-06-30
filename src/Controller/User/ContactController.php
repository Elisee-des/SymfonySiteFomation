<?php

namespace App\Controller\User;

use App\Form\ContactType;
use Mail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/utilisateur/contact", name="utilisateur_contact")
     */
    public function contact(): Response
    {
        return $this->render('user/contact/index.html.twig', []);
    }

    /**
     * @Route("/utilisateur/contact/email", name="utilisateur_contact_email")
     */
    public function contactEmail(Request $request): Response
    {
        /**
         * @var User
         */
        $user = $this->getUser();
        $form = $this->createForm(ContactType::class);

        $contact = $form->handleRequest($request);

        // $emailTo = $user->getEmail();
        // $name = $user->getNom();
        $emailTo =  $contact->get('email')->getData();
        $subject = $contact->get('sujet')->getData();
        $content = $contact->get('message')->getData();

        if ($form->isSubmitted() && $form->isValid()) {

            $email = new Mail();
            $email->send($emailTo, $subject, $content);

            $this->addFlash(
                'message',
                "Votre email a bien ete envoyez. Nous vous contacterons bientot"
            );

            // return $this->redirectToRoute('utilisateur_contact');
        }



        return $this->render('user/contact/email.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
