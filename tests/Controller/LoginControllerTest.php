<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLogin(): void
    {
        $client = static::createClient();

        $userRepo = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepo->findOneByEmail('admin@example.com');

        $client->loginUser($testUser);

        $client->followRedirects();

        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('#button-Logout', 'Log Out');
    }
}
