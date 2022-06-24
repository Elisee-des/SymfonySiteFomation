<?php

namespace App\Controller\User;

use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
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
        return $this->render('user/contact/contact.html.twig', []);
    }

    /**
     * @Route("/utilisateur/contact/email", name="utilisateur_contact_email")
     */
    public function contactEmail(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

        $contact = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
            ->from($contact->get('email')->getData())
            ->to("yentemasabidani@gmail.com")
            ->subject("Test Mail")
            ->htmlTemplate("user/contact/emailModel.html.twig")
            ->context([
                'mail' => $contact->get("email")->getData(),
                'sujet' => $contact->get("sujet")->getData(),
                'message' => $contact->get("message")->getData()
            ]);
            // dd($email);

            $mailer->send($email);

            $this->addFlash(
               'message',
               "Votre email a bien ete envoyez. Nous vous contacterons bientot"
            );

            return $this->redirectToRoute('utilisateur_contact');
        }

        return $this->render('user/contact/email.html.twig', [
            "form" => $form->createView()
        ]);
    }

}
