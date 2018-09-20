<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ContactController extends AbstractController
{
    /**
     * @Route("/kontakt", name="contact")
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();

            $message = (new \Swift_Message($message->getSubject()))
                ->setFrom($message->getEmail(), $message->getName())
                ->setTo([
                    'preasi-sgtuggen@bluewin.ch' => 'Präsident SG Tuggen',
                    'martin@duss-janser.ch' => 'Martin Janser',
                ])
                ->setBody(
                    $this->renderView(
                        // templates/emails/registration.html.twig
                        'contact.email.txt.twig',
                        ['message' => $message]
                    ),
                    'text/plain'
                )
            ;

            $mailer->send($message);

            return $this->redirectToRoute('contact_success');
        }

        return $this->render('contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/kontakt-gesendet", name="contact_success")
     */
    public function success()
    {
        return $this->render('contact.success.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
}
