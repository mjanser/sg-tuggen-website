<?php

/*
 * This file is part of the SgTuggen\ContactBundle
 *
 * (c) Martin Janser <martin@gogan.ch>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SgTuggen\ContactBundle\Controller;

use SgTuggen\ContactBundle\Model\Message;
use SgTuggen\ContactBundle\Form\Type\ContactType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Swift_Message;

class DefaultController extends Controller
{
    /**
     * Display the contact form
     *
     * @param Request $request
     *
     * @return Response
     */
    public function formAction(Request $request)
    {
        if ($request->query->get('sent')) {
            return $this->render('SgTuggenContactBundle:Default:success.html.twig');
        }

        $message = new Message();
        $form = $this->createForm(new ContactType(), $message);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $email = Swift_Message::newInstance()
                    ->setSubject(sprintf('SG Tuggen Kontaktanfrage: %s', $message->getSubject()))
                    ->setFrom($message->getEmail(), $message->getName())
                    ->setTo('sgtuggen@gogan.ch', 'SG Tuggen')
                    ->setBody(
                        $this->renderView(
                            'SgTuggenContactBundle:Default:email.txt.twig',
                            array('message' => $message)
                        )
                    );
                $this->get('mailer')->send($email);

                return $this->redirect($this->generateUrl('/cms/simple/kontakt', array('sent' => 1)));
            }
        }

        return $this->render('SgTuggenContactBundle:Default:form.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
