<?php

declare(strict_types=1);

namespace Infrastructure\Frontend;

use Infrastructure\Symfony\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

final class ContactController extends AbstractController
{
    #[Route('/kontakt', name: 'contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && null !== ($message = $form->getData())) {
            $message = (new Email())
                ->subject($message->getSubject() ?? '')
                ->from(new Address($message->getEmail() ?? '', $message->getName() ?? ''))
                ->to(new Address('praesi-sgtuggen@bluewin.ch', 'Präsident SG Tuggen'))
                ->addTo(new Address('martin@duss-janser.ch', 'Martin Janser'))
                ->text(
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

    #[Route('/kontakt-gesendet', name: 'contact_success')]
    public function success(): Response
    {
        return $this->render('contact.success.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
}
