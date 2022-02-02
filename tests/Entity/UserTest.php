<?php

namespace App\Tests\Entity;

use App\Entity\TODO;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testSetName(): void
    {
        $user = new User();
        $user->setFirstName("Andrew");
        $user->setLastName("Something");
        $this->assertSame('Andrew',$user->getFirstName());
        $this->assertSame('Something',$user->getLastName());
    }
    public function testSetEmail(): void
    {
        $user = new User();
        $user->setEmail('admin@admin.admin');
        $this->assertSame('admin@admin.admin', $user->getEmail());
        $this->assertSame('admin@admin.admin', $user->getUserIdentifier());
    }
    public function testRoles(): void
    {
        $user = new User();
        $this->assertSame(['ROLE_USER'], $user->getRoles());
        $user->setRoles(['ROLE_CAT']);
        $this->assertSame(['ROLE_CAT','ROLE_USER'],$user->getRoles());
    }
    public function testPassword(): void
    {
        $user = new User();
        $user->setPassword('cat');
        $this->assertSame('cat', $user->getPassword());
        $user->setPlainPassword('dog');
        $this->assertSame('dog',$user->getPlainPassword());
        $user->eraseCredentials();
        $this->assertSame(null,$user->getPlainPassword());
        $this->expectError();$user->setPlainPassword(null);
    }
    public function testIsVerified(): void
    {
        $user = new User();
        $this->assertSame(false, $user->getIsVerified());
        $user->setIsVerified(true);
        $this->assertSame(true, $user->getIsVerified());
        $user->setIsVerified(false);
        $this->assertSame(false, $user->getIsVerified());
    }
    public function testLastLoggedIn(): void
    {
        $user = new User();
        $time = new \DateTime();
        $user->setLastLoggedIn($time);
        $this->assertSame($time,$user->getLastLoggedIn());
        $time2 = new \DateTime();
        $user->setLastLoggedIn($time2);
        $this->assertSame($time2,$user->getLastLoggedIn());
        $this->assertNotEquals($time,$time2);
        $this->assertNotSame($time,$user->getLastLoggedIn());
    }
    public function testTODOList(): void
    {
        $user = new User();
        $this->assertEmpty($user->getTODOList());
        $user->addTODOList($TODO1 = new TODO());
        $this->assertNotEmpty($user->getTODOList());
        $this->assertSame($TODO1->getAssignedTo(), $user);

        $user->removeTODOList($TODO1);
        $this->assertEmpty($user->getTODOList());

        $this->assertNotSame($TODO1->getAssignedTo(), $user);
        $this->assertNull($TODO1->getAssignedTo());
    }
}
