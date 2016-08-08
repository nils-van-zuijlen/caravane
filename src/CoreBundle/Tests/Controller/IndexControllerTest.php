<?php

namespace CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

    public function testContact()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact');
    }

    public function testLinks()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/links');
    }

    public function testTerms()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/conditions-d-utilisation');
    }

    public function testCredits()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/credits');
    }

}
