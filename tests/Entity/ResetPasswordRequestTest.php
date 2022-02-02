<?php

namespace App\Tests\Entity;

use App\Entity\ResetPasswordRequest;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ResetPasswordRequestTest extends TestCase
{
    public function testConstruct() :void
    {
        $resetPass = new ResetPasswordRequest($user = new User(), $expiresAt = new \DateTime(), $selector = 'yes', $hashedToken = 'no');
        $this->assertSame($user, $resetPass->getUser());
        $this->assertIsObject($resetPass);

    }
}
