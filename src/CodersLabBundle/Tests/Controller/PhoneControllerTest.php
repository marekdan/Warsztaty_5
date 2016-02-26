<?php

namespace CodersLabBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PhoneControllerTest extends WebTestCase
{
    public function testNewphone()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/newPhone');
    }

}
