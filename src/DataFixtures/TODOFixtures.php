<?php

namespace App\DataFixtures;

use App\Factory\TODOFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TODOFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        TODOFactory::createMany(10);
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
