<?php

/*
 * This file is part of the SgTuggen\MainBundle
 *
 * (c) Martin Janser <martin@gogan.ch>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SgTuggen\MainBundle\DataFixtures\PHPCR;

use Symfony\Component\Yaml\Parser;
use Symfony\Cmf\Bundle\SimpleCmsBundle\DataFixtures\LoadCmsData;

class LoadStaticData extends LoadCmsData
{
    public function getOrder()
    {
        return 5;
    }

    protected function getData()
    {
        $yaml = new Parser();
        return $yaml->parse(file_get_contents(__DIR__ . '/../../Resources/data/page.yml'));
    }
}
