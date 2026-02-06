<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Task;
use Faker\Factory;
use Faker\Generator;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $Task = new Task();

            $Task->setTitle('First Task');
            $Task->setDescription('This is the description of the first task.');
            $Task->setIsCompleted(false);
            $Task->setCreatedAt(new \DateTimeImmutable());
            
            $manager->persist($Task);

            $Task = new Task();   
            $Task->setTitle('Second Task');
            $Task->setDescription('This is the description of the second task.');
            $Task->setIsCompleted(true);
            $Task->setCreatedAt(new \DateTimeImmutable());
           
            $manager->persist($Task);

        $manager->flush();
    }
}
