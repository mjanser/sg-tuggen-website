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

use SgTuggen\ContactBundle\Handler\MailHandler;

class MailHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MailHandler
     */
    protected $handler;

    public function setUp()
    {
        $this->handler = new MailHandler();
    }

    public function testSetMailer()
    {
        $mailer = $this->getMockMailer();
        $returnValue = $this->handler->setMailer($mailer);
        $this->assertAttributeSame($mailer, 'mailer', $this->handler);
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
        $this->assertInstanceOf('Swift_Message', $this->handler->getMessage());
    }

    public function testSetSubjectTemplate()
    {
        $subject = 'My subject: %s';
        $returnValue = $this->handler->setSubjectTemplate($subject);
        $this->assertAttributeSame($subject, 'subjectTemplate', $this->handler);
        $this->assertSame($this->handler, $returnValue);
    }

    public function testSetRecipients()
    {
        $recipients = array('info@example.com');
        $returnValue = $this->handler->setRecipients($recipients);
        $this->assertAttributeSame($recipients, 'recipients', $this->handler);
        $this->assertSame($this->handler, $returnValue);
    }

    /**
     * @depends testSetMailer
     * @depends testSetRecipients
     * @depends testSetMessage
     * @depends testSetSubjectTemplate
     */
    public function testSend()
    {
        $subjectTemplate = 'Custom: %s';
        $recipients = array('info@example.com');
        $body       = 'My body';
        $subject    = 'My subject';
        $email      = 'noreply@example.com';
        $name       = 'My name';

        $entity = $this->getMockEntity();
        $entity->expects($this->once())->method('getSubject')->will($this->returnValue($subject));
        $entity->expects($this->once())->method('getEmail')->will($this->returnValue($email));
        $entity->expects($this->once())->method('getName')->will($this->returnValue($name));

        $message = $this->getMockMessage();
        $message->expects($this->once())->method('setSubject')->with('Custom: ' . $subject)->will($this->returnSelf());
        $message->expects($this->once())->method('setFrom')->with($email, $name)->will($this->returnSelf());
        $message->expects($this->once())->method('setTo')->with($recipients)->will($this->returnSelf());
        $message->expects($this->once())->method('setBody')->with($body)->will($this->returnSelf());

        $mailer = $this->getMockMailer();
        $mailer
            ->expects($this->once())
            ->method('send')
            ->with($message)
            ->will($this->returnValue(1));

        $this->handler->setMailer($mailer);
        $this->handler->setRecipients($recipients);
        $this->handler->setMessage($message);
        $this->handler->setSubjectTemplate($subjectTemplate);

        $this->handler->send($entity, $body);
    }

    /**
     * @depends testSetMailer
     * @depends testSetRecipients
     */
    public function testSendWithEmptyRecipients()
    {
        $recipients = array();
        $body       = 'My body';

        $entity = $this->getMockEntity();

        $mailer = $this->getMockMailer();
        $mailer->expects($this->never())->method('send');

        $this->handler->setMailer($mailer);
        $this->handler->setRecipients($recipients);

        $this->handler->send($entity, $body);
    }

    /**
     * @depends testSetRecipients
     * @depends testSetMessage
     *
     * @expectedException SgTuggen\ContactBundle\Exception\HandlerNotInitializedException
     */
    public function testSendWithoutMailer()
    {
        $recipients = array('info@example.com');
        $body       = 'My body';

        $entity = $this->getMockEntity();
        $message = $this->getMockMessage();

        $this->handler->setRecipients($recipients);
        $this->handler->setMessage($message);

        $this->handler->send($entity, $body);
    }

    /**
     * @depends testSetMailer
     * @depends testSetMessage
     *
     * @expectedException SgTuggen\ContactBundle\Exception\HandlerNotInitializedException
     */
    public function testSendWithoutRecipients()
    {
        $body = 'My body';

        $entity = $this->getMockEntity();
        $message = $this->getMockMessage();
        $mailer = $this->getMockMailer();

        $this->handler->setMailer($mailer);
        $this->handler->setMessage($message);

        $this->handler->send($entity, $body);
    }

    /**
     * @depends testSetMailer
     * @depends testSetRecipients
     * @depends testSetMessage
     *
     * @expectedException SgTuggen\ContactBundle\Exception\HandlerNotInitializedException
     */
    public function testSendWithoutSubjectTemplate()
    {
        $recipients = array('info@example.com');
        $body = 'My body';

        $entity = $this->getMockEntity();
        $message = $this->getMockMessage();
        $mailer = $this->getMockMailer();

        $this->handler->setMailer($mailer);
        $this->handler->setRecipients($recipients);
        $this->handler->setMessage($message);
        $this->handler->setSubjectTemplate('');

        $this->handler->send($entity, $body);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockMailer()
    {
        return $this->getMock('Swift_Mailer', array(), array(), '', false);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockMessage()
    {
        return $this->getMock('Swift_Message', array(), array(), '', false);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockEntity()
    {
        return $this->getMock('SgTuggen\ContactBundle\Model\MessageInterface');
    }
}
