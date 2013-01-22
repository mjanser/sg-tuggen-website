<?php

/*
 * This file is part of the SgTuggen\ContactBundle
 *
 * (c) Martin Janser <martin@gogan.ch>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SgTuggen\ContactBundle\Tests\Handler;

use SgTuggen\ContactBundle\Handler\FormHandler;

class FormHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FormHandler
     */
    protected $handler;

    public function setUp()
    {
        $this->handler = new FormHandler();
    }

    public function testSetFormFactory()
    {
        $formFactory = $this->getMockFormFactory();
        $returnValue = $this->handler->setFormFactory($formFactory);
        $this->assertAttributeSame($formFactory, 'formFactory', $this->handler);
        $this->assertSame($this->handler, $returnValue);
    }

    public function testSetMessage()
    {
        $message = $this->getMockMessage();
        $returnValue = $this->handler->setMessage($message);
        $this->assertAttributeSame($message, 'message', $this->handler);
        $this->assertSame($this->handler, $returnValue);
    }

    /**
     * @depends testSetMessage
     */
    public function testGetMessage()
    {
        $message = $this->getMockMessage();
        $this->handler->setMessage($message);
        $this->assertSame($message, $this->handler->getMessage());
    }

    public function testGetNewMessage()
    {
        $this->assertInstanceOf('SgTuggen\ContactBundle\Model\Message', $this->handler->getMessage());
    }

    /**
     * @depends testSetFormFactory
     * @depends testSetMessage
     * @depends testGetMessage
     */
    public function testGetForm()
    {
        $form = $this->initializeHandler();

        $result = $this->handler->getForm();
        $this->assertSame($form, $result);

        $result = $this->handler->getForm();
        $this->assertSame($form, $result);
    }

    /**
     * @expectedException SgTuggen\ContactBundle\Exception\HandlerNotInitializedException
     */
    public function testGetFormWithoutFormFactory()
    {
        $this->handler->getForm();
    }

    /**
     * @depends testSetFormFactory
     * @depends testSetMessage
     * @depends testGetMessage
     * @depends testGetForm
     */
    public function testUpdate()
    {
        $data = array();

        $form = $this->initializeHandler();
        $form
            ->expects($this->once())
            ->method('bind')
            ->with($data)
            ->will($this->returnSelf());
        $form
            ->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));

        $this->handler->update($data);
    }

    /**
     * @depends testSetFormFactory
     * @depends testSetMessage
     * @depends testGetMessage
     * @depends testGetForm
     *
     * @expectedException SgTuggen\ContactBundle\Exception\HandlerValidationException
     */
    public function testUpdateWithInvalidData()
    {
        $data = array();

        $form = $this->initializeHandler();
        $form
            ->expects($this->once())
            ->method('bind')
            ->with($data)
            ->will($this->returnSelf());
        $form
            ->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));

        $this->handler->update($data);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function initializeHandler()
    {
        $form = $this->getMock('Symfony\Component\Form\Form', array(), array(), '', false);
        $message = $this->getMockMessage();

        $formFactory = $this->getMockFormFactory();
        $formFactory
            ->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->handler->setFormFactory($formFactory);
        $this->handler->setMessage($message);

        return $form;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockFormFactory()
    {
        return $this->getMock('Symfony\Component\Form\FormFactoryInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockMessage()
    {
        return $this->getMock('SgTuggen\ContactBundle\Model\MessageInterface');
    }
}
