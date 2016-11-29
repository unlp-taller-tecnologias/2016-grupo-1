<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BackupControllerTest extends WebTestCase
{
    public function testBackup()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/backup');
    }

}
