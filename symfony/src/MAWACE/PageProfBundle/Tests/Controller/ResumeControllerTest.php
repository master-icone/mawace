<?php
// src/MAWACE/PageProfBundle/Tests/Controller/ResumeControllerTest.php

namespace MAWACE\PageProfBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResumeControllerTest extends WebTestCase
{
    public function testAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/page-professeur/1');

        $this->assertEquals(1, $crawler->filter('h1:contains("DEMKO")')->count());
    }
}
