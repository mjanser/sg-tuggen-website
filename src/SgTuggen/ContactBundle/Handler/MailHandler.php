<?php

/*
 * This file is part of the SgTuggen\ContactBundle
 *
 * (c) Martin Janser <martin@gogan.ch>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SgTuggen\ContactBundle\Handler;

use SgTuggen\ContactBundle\Exception\HandlerNotInitializedException;

use SgTuggen\ContactBundle\Model\MessageInterface;

use \Swift_Mailer;
use \Swift_Message;

class MailHandler
{
    /**
     * @var Swift_Mailer
     */
    protected $mailer;

    /**
     * @var Swift_Message
     */
    protected $message;

    /**
     * Template to use for the e-mail subject
     *
     * @var string
     */
    protected $subjectTemplate = '%s';

    /**
     * Recipient addresses
     *
     * @var array
     */
    protected $recipients;

    /**
     * Set the Mailer instance
     *
     * @param Swift_Mailer $formFactory
     *
     * @return MailHandler
     */
    public function setMailer(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;

        return $this;
    }

    /**
     * Set the Swift_Message instance
     *
     * @param Swift_Message $message
     *
     * @return MailHandler
     */
    public function setMessage(Swift_Message $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Returns the Swift_Message instance
     *
     * @return Swift_Message
     */
    public function getMessage()
    {
        if (!$this->message) {
            $this->message = Swift_Message::newInstance();
        }

        return $this->message;
    }

    /**
     * Set a template string for the e-mail subject
     *
     * @param string $template
     *
     * @return MailHandler
     */
    public function setSubjectTemplate($template)
    {
        $this->subjectTemplate = $template;

        return $this;
    }

    /**
     * Set the recipient addresses
     *
     * @param array $addresses
     *
     * @return MailHandler
     */
    public function setRecipients(array $addresses)
    {
        $this->recipients = $addresses;

        return $this;
    }

    /**
     * Send an e-mail
     *
     * @param MessageInterface $entity
     * @param string           $body
     *
     * @throws HandlerNotInitializedException If no Mailer set
     * @throws HandlerNotInitializedException If subject template set
     * @throws HandlerNotInitializedException If recipients set
     */
    public function send(MessageInterface $entity, $body)
    {
        if (!$this->mailer) {
            throw new HandlerNotInitializedException('Mailer was not set');
        }
        if (!$this->subjectTemplate) {
            throw new HandlerNotInitializedException('No subject template set');
        }
        if (!$this->recipients) {
            throw new HandlerNotInitializedException('No recipient addresses set');
        }

        $email = $this->getMessage()
            ->setSubject(sprintf($this->subjectTemplate, $entity->getSubject()))
            ->setFrom($entity->getEmail(), $entity->getName())
            ->setTo($this->recipients)
            ->setBody($body);

        $this->mailer->send($email);
    }
}
