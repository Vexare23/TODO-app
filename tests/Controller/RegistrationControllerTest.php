<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testRegistration(): void
    {
        $client = static::createClient();

        $userRepo = static::getContainer()->get(UserRepository::class);

        $client->request('GET', 'register');

        $user = new User();

        $client->submitForm('Register', [
            'registration_form[email]' => 'foo@example.com',
            'registration_form[firstName]' => 'Foo',
            'registration_form[lastName]' => 'Bar',
            'registration_form[plainPassword]' => 'foobar123',
            'registration_form[agreeTerms]' => true
        ]);

        $userByEmail = $userRepo->findOneByEmail('foo@example.com');

        $sentMail = $this->getMailerMessage(0);

        $this->assertSame('foo@example.com', $userByEmail->getEmail());
        $this->assertEmailCount(1);
        $this->assertEmailHeaderSame($sentMail, 'To', 'foo@example.com');

        $client->followRedirect();
        $this->assertResponseIsSuccessful();
    }
}
