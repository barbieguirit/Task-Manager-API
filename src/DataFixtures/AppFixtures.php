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
         $product = new Product();

            $product->setTitle('First Task');
            $product->setDescription('This is the description of the first task.');
            $product->setIsCompleted(false);
            $product->setCreatedAt(new \DateTimeImmutable());
            
            $manager->persist($product);

            $product = new Product();   
            $product->setTitle('Second Task');
            $product->setDescription('This is the description of the second task.');
            $product->setIsCompleted(true);
            $product->setCreatedAt(new \DateTimeImmutable());
           
            $manager->persist($product);

        $manager->flush();
    }
}
