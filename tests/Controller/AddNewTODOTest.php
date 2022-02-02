<?php

namespace App\Tests\Controller;

use App\Repository\TODORepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddNewTODOTest extends WebTestCase
{
    public function testAddTodo(): void
    {
        $client = static::createClient();

        $userRepo = static::getContainer()->get(UserRepository::class);

        $todoRepo = static::getContainer()->get(TODORepository::class);

        $testUser = $userRepo->findOneByEmail('admin@example.com');
        $client->loginUser($testUser);
        $client->followRedirects();

        $client->request('GET', '/newTODO');

        $client->submitForm('Add', [
            'todo_form[name]' => 'Create',
            'todo_form[description]' => 'Combine the elements',
            'todo_form[datetime]' => '2022-01-23T11:53:34',
            'todo_form[assignedTo]' => 'admin@example.com',
        ]);

        $todo = $todoRepo->find('40');

        $this->assertResponseIsSuccessful();
        $this->assertSame(40, $todo->getId());
    }
}
