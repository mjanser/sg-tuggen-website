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

use SgTuggen\ContactBundle\Model\MessageInterface;
use SgTuggen\ContactBundle\Model\Message;
use SgTuggen\ContactBundle\Form\Type\ContactType;

use SgTuggen\ContactBundle\Exception\HandlerValidationException;
use SgTuggen\ContactBundle\Exception\HandlerNotInitializedException;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class FormHandler
{
    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * Set the FormFactory instance
     *
     * @param FormFactoryInterface $formFactory
     *
     * @return FormHandler
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;

        return $this;
    }

    /**
     * Set the message model
     *
     * @param MessageInterface $message
     *
     * @return FormHandler
     */
    public function setMessage(MessageInterface $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Returns the message model
     *
     * @return MessageInterface
     */
    public function getMessage()
    {
        if (!$this->message) {
            $this->setMessage(new Message());
        }

        return $this->message;
    }

    /**
     * Create and return a form
     *
     * @return FormInterface
     *
     * @throws HandlerNotInitializedException If no FormFactory set
     */
    public function getForm()
    {
        if (!$this->form) {
            if (!$this->formFactory) {
                throw new HandlerNotInitializedException('FormFactory was not set');
            }

            $this->form = $this->formFactory->create(new ContactType(), $this->getMessage());
        }

        return $this->form;
    }

    /**
     * Update the entity
     *
     * @param null|string|array $submittedData The data
     *
     * @throws HandlerValidationException If validation errors occurred
     */
    public function update($submittedData)
    {
        $form = $this->getForm();
        $form->bind($submittedData);

        if (!$form->isValid()) {
            throw new HandlerValidationException('Data is not valid');
        }
    }
}
