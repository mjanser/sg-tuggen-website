<?php

/*
 * This file is part of the SgTuggen\ContactBundle
 *
 * (c) Martin Janser <martin@gogan.ch>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SgTuggen\ContactBundle\Tests\DependencyInjection;

use SgTuggen\ContactBundle\DependencyInjection\SgTuggenContactExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SgTuggenContactExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SgTuggenContactExtension
     */
    private $extension;

    public function setUp()
    {
        $this->extension = new SgTuggenContactExtension();
    }

    public function testConfigLoad()
    {
        $config = array(
            'email' => array(
                'subject'    => 'My subject: %s',
                'recipients' => array(
                    'john@example.com' => 'John Doe'
                )
            )
        );
        $this->extension->load(array($config), $container = $this->getContainer());

        $this->assertTrue($container->hasDefinition('sgtuggen.contact.form_handler'));
        $this->assertTrue($container->hasDefinition('sgtuggen.contact.mail_handler'));

        $this->assertEquals('My subject: %s', $container->getParameter('sgtuggen_contact.email.subject'));
        $this->assertEquals(array('john@example.com' => 'John Doe'), $container->getParameter('sgtuggen_contact.email.recipients'));
    }

    private function getContainer()
    {
        $container = new ContainerBuilder();

        return $container;
    }
}
