<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Genre;
use App\Entity\Loan;
use App\Entity\Type;
use App\Entity\User;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LoanFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');

        $type = new Type();
        $type -> setName($faker->word())
              -> setDescription($faker->paragraph());
        $manager -> persist ($type);

        // Genre
            $genre = new Genre();
            $genre -> setName($faker->word())
                   -> setDescription($faker->paragraph());
            $manager -> persist ($genre);

            // Book
                $book = new Book();
                $book -> setTitle($faker->sentence())
                      -> setSummary($faker->paragraph())
                      -> setQuantity($faker->numberBetween(1, 33))
                      -> setPublishedDate($faker->dateTimeBetween('-15 years'))
                      -> setTypeId($type)                          
                      -> setAuthor($faker->name())
                      -> setGenreId($genre);
                $manager -> persist($book);
        


        $loan = new Loan();
        $user = new User();

        $user -> setFirstname($faker->firstName())
        -> setLastname($faker->lastName())
        ->setEmail('librarian2l@email.fr')
        ->setPassword('abcd1234')
        ->setGender('M')
        ->setRoles(["ROLE_LIBRARIAN"]);
        $manager -> persist($user);

        $loan -> setLoanDate($faker->dateTimeBetween('-3 months'))
              -> setUserId($user)
              -> setBookId($book);

        $manager -> persist($loan);

        $manager->flush();
    }
}
