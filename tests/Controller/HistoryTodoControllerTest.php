<?php

namespace App\Tests\Controller;

use App\Repository\TODORepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HistoryTodoControllerTest extends WebTestCase
{
    public function testHistory(): void
    {
        $client = static::createClient();

        $userRepo = static::getContainer()->get(UserRepository::class);

        $todoRepo = static::getContainer()->get(TODORepository::class);

        $client->request('GET', '/record/todo/55');

        $this->assertSelectorTextContains('#h_name_2_55', 'Mandragora');

        $testUser = $userRepo->findOneByEmail('admin@example.com');
        $client->loginUser($testUser);
        $client->followRedirects();

        $client->request('GET', '/editTODO/55');

        $client->submitForm('Save', [
            'edit_todo_form[name]' => 'foo',
            'edit_todo_form[description]' => 'foo',
            'edit_todo_form[datetime]' => '2022-01-24T11:53:34',
            'edit_todo_form[status]' => 0,
        ]);

        $client->request('GET', '/record/todo/55');

        $this->assertSelectorTextContains('#h_name_1_55', 'foo');
    }
}
