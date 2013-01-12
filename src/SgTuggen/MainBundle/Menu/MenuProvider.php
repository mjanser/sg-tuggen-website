<?php

/*
 * This file is part of the SgTuggen\MainBundle
 *
 * (c) Martin Janser <martin@gogan.ch>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SgTuggen\MainBundle\Menu;

use Symfony\Cmf\Bundle\MenuBundle\Provider\PHPCRMenuProvider;
use Knp\Menu\MenuItem;

class MenuProvider extends PHPCRMenuProvider
{
    public function get($name, array $options = array())
    {
        $menu = parent::get($name, $options);

        if ($name === 'simple') {
            $item = new MenuItem('Startseite', $this->factory);
            $item->setUri($menu->getUri());
            $menu->addChild($item);
            $item->moveToFirstPosition();
        }

        return $menu;
    }
}