<?php

/*
 * This file is part of the SgTuggen\ContactBundle
 *
 * (c) Martin Janser <martin@gogan.ch>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SgTuggen\ContactBundle\Tests\Model;

use SgTuggen\ContactBundle\Model\Message;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Message
     */
    protected $message;

    public function setUp()
    {
        $this->message = new Message();
    }

    public function testSetName()
    {
        $this->message->setName('John Doe');
        $this->assertAttributeEquals('John Doe', 'name', $this->message);
    }

    public function testSetEmail()
    {
        $this->message->setEmail('john@example.com');
        $this->assertAttributeEquals('john@example.com', 'email', $this->message);
    }

    public function testSetSender()
    {
        $this->message->setSender('John Doe', 'john@example.com');
        $this->assertAttributeEquals('John Doe', 'name', $this->message);
        $this->assertAttributeEquals('john@example.com', 'email', $this->message);
    }

    /**
     * @depends testSetSender
     */
    public function testGetName()
    {
        $this->message->setSender('John Doe', 'john@example.com');
        $this->assertEquals('John Doe', $this->message->getName());
    }

    /**
     * @depends testSetSender
     */
    public function testGetEmail()
    {
        $this->message->setSender('John Doe', 'john@example.com');
        $this->assertEquals('john@example.com', $this->message->getEmail());
    }

    public function testSetSubject()
    {
        $this->message->setSubject('My subject');
        $this->assertAttributeEquals('My subject', 'subject', $this->message);
    }

    /**
     * @depends testSetSubject
     */
    public function testGetSubject()
    {
        $this->message->setSubject('My subject');
        $this->assertEquals('My subject', $this->message->getSubject());
    }

    public function testSetBody()
    {
        $this->message->setBody('My body');
        $this->assertAttributeEquals('My body', 'body', $this->message);
    }

    /**
     * @depends testSetBody
     */
    public function testGetBody()
    {
        $this->message->setBody('My body');
        $this->assertEquals('My body', $this->message->getBody());
    }
}
