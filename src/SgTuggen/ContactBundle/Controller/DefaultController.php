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
use SgTuggen\ContactBundle\Exception\HandlerValidationException;

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

        $formHandler = $this->get('sgtuggen.contact.form_handler');

        if ($request->isMethod('POST')) {
            try {
                $formHandler->update($request);
            } catch (HandlerValidationException $e) {
                $response = $this->render('SgTuggenContactBundle:Default:form.html.twig', array(
                    'form' => $formHandler->getForm()->createView()
                ));
                $response->setStatusCode(400);

                return $response;
            }

            $message     = $formHandler->getMessage();
            $mailHandler = $this->get('sgtuggen.contact.mail_handler');
            $mailHandler->send($message, $this->renderView(
                'SgTuggenContactBundle:Default:email.txt.twig',
                array('message' => $message)
            ));

            return $this->redirect($this->generateUrl('/cms/simple/kontakt', array('sent' => 1)));
        }

        return $this->render('SgTuggenContactBundle:Default:form.html.twig', array(
            'form' => $formHandler->getForm()->createView()
        ));
    }
}
