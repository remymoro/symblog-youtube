<?php
namespace App\Tests\Functional;





use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BasicTest extends WebTestCase

{

    public function testEnvironnementOk(): void

    {

        $client = static::createClient();

        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }
}
