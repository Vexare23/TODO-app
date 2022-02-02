<?php

namespace App\Tests\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiShowTODOsTest extends WebTestCase
{
    public function testShowTodos(): void
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->jsonRequest('GET', '/api/showTODOs');

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(),true);
        foreach ($data['TODO'] as $TODO)
        {
            if ($TODO['name'] == 'test'){
                $this->assertEquals($TODO['description'], 'test');
            }
        }
        $this->assertCount(12,$data['TODO']);
        $this->assertEquals($data['TODO'][11]['name'], 'test?');
        echo $client->getResponse();
    }
}
