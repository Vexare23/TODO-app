<?php

namespace App\Tests\Entity;

use App\Entity\TODO;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TODOTest extends TestCase
{
    public function testSetName(): void
    {
        $todo = new TODO();
        $todo->setName('Testing water');
        $this->assertSame('Testing water',$todo->getName());
    }
    public function testSetDescription(): void
    {
        $todo = new TODO();
        $todo->setDescription('Testing water by drinking it');
        $this->assertSame('Testing water by drinking it',$todo->getDescription());
    }
    public function testDatetime(): void
    {
        $todo = new TODO();
        $time = new \DateTime();
        $todo->setDatetime($time);
        $this->assertSame($time,$todo->getDatetime());
        $time2 = new \DateTime();
        $todo->setDatetime($time2);
        $this->assertSame($time2,$todo->getDatetime());
        $this->assertNotEquals($time,$time2);
        $this->assertNotSame($time,$todo->getDatetime());
    }
    public function testStatus():void
    {
        $todo = new TODO();
        $this->assertFalse($todo->getStatus());
        $todo->setStatus(true);
        $this->assertNotFalse($todo->getStatus());
    }
    public function testAssignedTo(): void
    {
        $todo = new TODO();
        $this->assertNull($todo->getAssignedTo());
        $user1 = new User();
        $user2 = new User();
        $todo->setAssignedTo($user1);
        $this->assertSame($todo->getAssignedTo(),$user1);
        $todo->setAssignedTo($user2);
        $this->assertNotSame($todo->getAssignedTo(),$user1);
        $this->assertSame($todo->getAssignedTo(),$user2);
        $this->assertNotSame($user1->getTODOList()[0],$todo);
    }
}
