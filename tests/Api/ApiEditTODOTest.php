<?php

namespace App\Tests\Api;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiEditTODOTest  extends WebTestCase
{
    public function testEditATodo(): void
    {
        $client = static::createClient();

        $data = [
            'name' => 'test!',
            'description' => 'test?',
            'datetime' => '23/05/2023',
            'status' => false,
        ];

        $client->jsonRequest('PUT', '/api/editTODO/7', $data);
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $finishedData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('description', $finishedData);
        $this->assertEquals('test!', $finishedData['name']);
    }
}
