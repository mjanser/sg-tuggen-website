<?php

/*
 * This file is part of the SgTuggen\ContactBundle
 *
 * (c) Martin Janser <martin@gogan.ch>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SgTuggen\ContactBundle\Tests;

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

    public function testContactFormIsDisplayed()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/kontakt');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertCount(1, $crawler->filter('h1:contains("Kontakt")'), 'Page does not contain an h1 tag with: Kontakt');
        $this->assertCount(1, $crawler->filter('form'), 'Page does not contain a form tag');
        $this->assertCount(1, $crawler->filter('form input[type="submit"][name="submit"]'), 'Form does not contain a submit button');
    }

    /**
     * @depends testContactFormIsDisplayed
     */
    public function testContactFormDisplaysErrors()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/kontakt');
        $form = $crawler->selectButton('submit')->form();

        $form['contact[name]'] = 'John Doe';

        $crawler = $client->submit($form);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());

        $this->assertGreaterThan(1, count($crawler->filter('form .field.error ul.errors')), 'Form has no errors');
    }

    /**
     * @depends testContactFormIsDisplayed
     */
    public function testContactFormRedirectsAfterSubmit()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/kontakt');
        $form = $crawler->selectButton('submit')->form();

        $form['contact[name]']    = 'John Doe';
        $form['contact[email]']   = 'john@example.com';
        $form['contact[subject]'] = 'My subject';
        $form['contact[body]']    = 'This is for testing only!';

        $crawler = $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/kontakt?sent=1'));

        $crawler = $client->followRedirect();

        $this->assertCount(1, $crawler->filter('h1:contains("Kontaktanfrage gesendet")'), 'Page does not contain an h1 tag with: Kontaktanfrage gesendet');
    }
}
