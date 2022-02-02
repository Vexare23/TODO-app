<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();

        $client->followRedirects();

        $crawler = $client->request('GET', '/');

        $this->assertSelectorTextContains('#button-Login', 'Log In');

        $button = $crawler->filter('#button-Login')->link();

        $client->click($button);

        $this->assertSelectorTextContains('#button-Signin', 'Sign in');
    }
}
