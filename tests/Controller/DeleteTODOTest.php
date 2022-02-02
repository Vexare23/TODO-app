<?php

namespace App\Tests\Controller;

use App\Repository\TODORepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeleteTODOTest extends WebTestCase
{
    public function testDeleteTodo(): void
    {
        $client = static::createClient();

        $userRepo = static::getContainer()->get(UserRepository::class);

        $todoRepo = static::getContainer()->get(TODORepository::class);

        $testUser = $userRepo->findOneByEmail('admin@example.com');
        $client->loginUser($testUser);
        $client->followRedirects();

        $client->request('GET', '/deleteTODO/13');

        $this->assertInputValueSame('delete_todo_form[name]', 'Do a thing');

        $client->submitForm('Delete', [

        ]);

        $todo = $todoRepo->find('13');

        $this->assertResponseIsSuccessful();
        $this->assertSame(null, $todo);
        $this->assertSelectorTextContains('#button-Logout', 'Log Out');
    }
}
