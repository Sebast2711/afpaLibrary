<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('en_US');

        // Creation of 2 Users / admin = $librarian / abonné : $subscriber
        $librarian = new User();
        $subscriber = new User();

        $librarian -> setFirstname($faker->firstName())
                -> setLastname($faker->lastName())
                ->setEmail('librarian@email.fr')
                ->setPassword('abcd1234')
                ->setGender('Mme')
                ->setRoles([
                    "ROLE_LIBRARIAN"
                ]);

        $subscriber -> setFirstname($faker->firstName())
                -> setLastname($faker->lastName())
                ->setEmail('subscriber@email.fr')
                ->setPassword('abcd1234')
                ->setGender('M.');

        $manager->persist($librarian);
        $manager->persist($subscriber);

        $manager->flush();
    }
}
