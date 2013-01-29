<?php

/*
 * This file is part of the SgTuggen\MainBundle
 *
 * (c) Martin Janser <martin@gogan.ch>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SgTuggen\MainBundle\Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;

class StaticPageTest extends WebTestCase
{
    static protected $fixturesLoaded = false;

    public function setUp()
    {
        if (self::$fixturesLoaded) {
            return;
        }

        $this->loadFixtures(array(
            'SgTuggen\MainBundle\DataFixtures\PHPCR\LoadStaticData',
        ), null, 'doctrine_phpcr');

        self::$fixturesLoaded = true;
    }

    /**
     * @dataProvider contentDataProvider
     */
    public function testContent($url, $title)
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', $url);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertCount(1, $crawler->filter(sprintf('h1:contains("%s")', $title)), 'Page does not contain an h1 tag with: '.$title);
    }

    public function contentDataProvider()
    {
        return array(
            array('/', 'Willkommen bei'),
            array('/vorstand', 'Vorstand'),
            array('/schiessplan', 'Schiessplan'),
            array('/gruppenschiessen', 'Gruppenschiessen'),
            array('/feldschiessen', 'Feldschiessen'),
            array('/jungschuetzenkurs', 'Jungschützenkurs'),
            array('/links', 'Links'),
        );
    }

    public function testError404()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/invalid');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
