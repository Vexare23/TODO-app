<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResetPasswordControllerTest extends WebTestCase
{
    public function testResetPassword(): void
    {
        $client = static::createClient();

        $client->request('GET', '/reset-password');

        $client->submitForm('Send password reset email', [
            'reset_password_request_form[email]'=>'heaney.nellie@gmail.com'
        ]);

        $sentMail = $this->getMailerMessage(0);

        $this->assertEmailCount(1);

        $this->assertEmailHeaderSame($sentMail, 'To', 'heaney.nellie@gmail.com');

        $client->followRedirect();

        $this->assertResponseIsSuccessful();
    }
}
