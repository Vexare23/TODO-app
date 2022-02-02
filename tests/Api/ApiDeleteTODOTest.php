<?php

namespace App\Tests\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiDeleteTODOTest extends WebTestCase
{
    public function testDELETEaTodo(): void
    {
        $client = static::createClient();

        $id = 11;
        $client->jsonRequest('GET', '/api/showTODO/'.$id);
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('description', $data);
        $this->assertArrayHasKey('status', $data);

        $client->request('DELETE', '/api/deleteTODO/11');

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
        $this->assertEquals(null, $client->getResponse()->getContent());
    }
}
