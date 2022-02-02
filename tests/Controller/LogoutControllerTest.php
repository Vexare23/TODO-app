<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LogoutControllerTest extends WebTestCase
{
    public function testLogout(): void
    {
        $client = static::createClient();

        $userRepo = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepo->findOneByEmail('admin@example.com');

        $client->loginUser($testUser);

        $client->followRedirects();

        $crawler = $client->request('GET', '/');

        $this->assertSelectorTextContains('#tag-Username', 'Liana White');

        $button = $crawler->filter('#button-Logout')
            ->link();
        $client->click($button);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('#button-Login', 'Log In');
    }
}
