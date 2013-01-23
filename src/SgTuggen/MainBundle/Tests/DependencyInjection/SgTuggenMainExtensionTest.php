<?php

/*
 * This file is part of the SgTuggen\MainBundle
 *
 * (c) Martin Janser <martin@gogan.ch>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SgTuggen\MainBundle\Tests\DependencyInjection;

use SgTuggen\MainBundle\DependencyInjection\SgTuggenMainExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SgTuggenMainExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SgTuggenMainExtension
     */
    private $extension;

    public function setUp()
    {
        $this->extension = new SgTuggenMainExtension();
    }

    public function testConfigLoad()
    {
        $config = array();
        $this->extension->load(array($config), $container = $this->getContainer());

        $this->assertTrue($container->hasDefinition('symfony_cmf_menu.provider'));
    }

    private function getContainer()
    {
        $container = new ContainerBuilder();

        return $container;
    }
}
