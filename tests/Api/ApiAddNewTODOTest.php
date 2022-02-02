<?php

namespace App\Tests\Api;

use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiAddNewTODOTest extends WebTestCase
{
    public function testAddTodo(): void
    {
        $client = static::createClient();
        $client->followRedirects();

        $user = UserFactory::createOne();
        $data = array(
            'name' => 'test',
            'description' => 'test',
            'datetime' => '23/05/2023',
            'assignedTo' => $user->getId(),
        );

        $client->jsonRequest('POST', '/api/newTODO',$data);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('Location',$client->getResponse()->headers->allPreserveCase());
        $finishedData = json_decode($client->getResponse()->getContent(),true);
        $this->assertArrayHasKey('description', $finishedData);
        $this->assertEquals('test', $data['name']);
        //$this->assertEquals('/api/showTODO/71',$client->getResponse()->headers->get('Location'));
        echo $client->getResponse();
    }
}
