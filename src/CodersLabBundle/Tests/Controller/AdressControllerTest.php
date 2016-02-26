<?php

namespace CodersLabBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdressControllerTest extends WebTestCase
{
    public function testNewadress()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/newAdress');
    }

}
