<?php

namespace App\Tests\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiShowTODOTest extends WebTestCase
{
    public function testShowTodo(): void
    {
        $client = static::createClient();
        $client->followRedirects();
        $id = 3;
        $client->jsonRequest('GET', '/api/showTODO/'.$id);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('description', $data);
        $this->assertArrayHasKey('status', $data);

        echo $client->getResponse();


    }
}
