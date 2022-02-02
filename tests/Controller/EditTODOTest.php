<?php

namespace App\Tests\Controller;

use App\Repository\TODORepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EditTODOTest extends WebTestCase
{
    public function testEditTODO(): void
    {
        $client = static::createClient();

        $userRepo = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepo->findOneByEmail('admin@example.com');
        $adminName = $testUser->getFirstName() . " " . $testUser->getLastName();
        $client->loginUser($testUser);
        $client->followRedirects();

        $client->request('GET', '/editTODO/13');

        $this->assertInputValueSame('edit_todo_form[name]', 'Do a thing');

        $client->submitForm('Save', [
            'edit_todo_form[name]' => 'foo',
            'edit_todo_form[description]' => 'foo',
            'edit_todo_form[datetime]' => '2022-01-24T11:53:34',
            'edit_todo_form[status]' => 0,
            'edit_todo_form[assignedTo]' => $testUser->getId(),
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('#todo_name_13', 'foo');
        $this->assertSelectorTextContains('#todo_datetime_13', '24-01-2022 11:53');
        $this->assertSelectorTextContains('#todo_assigned_13', (string)$adminName);

    }
}
