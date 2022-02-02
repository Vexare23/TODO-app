<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne(['email'=>'admin@example.com',
            'roles'=>['ROLE_ADMIN'],
        ]);
        UserFactory::createMany(10, ['roles'=>['ROLE_USER']]);

        $manager->flush();
    }
}
