<?php

namespace CodersLabBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailControllerTest extends WebTestCase
{
    public function testNewemail()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/newEmail');
    }

}
