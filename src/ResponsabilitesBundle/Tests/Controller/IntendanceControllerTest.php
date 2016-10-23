<?php

namespace ResponsabilitesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IntendanceControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

    public function testViewmenu()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/viewMenu');
    }

    public function testNewmenu()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/menu/nouveau');
    }

    public function testEditmenu()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/menu/{slug}/edit');
    }

    public function testViewallmenu()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/menu');
    }

}
