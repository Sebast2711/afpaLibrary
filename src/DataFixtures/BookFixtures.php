<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Genre;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        $faker = \Faker\Factory::create('fr_FR');

        // Type 
        for ($i = 0; $i < mt_rand(2,7); $i++){
            $type = new Type();
            $type -> setName($faker->word())
                  -> setDescription($faker->paragraph());
            $manager -> persist ($type);

            // Genre
            for ($j = 0; $j < mt_rand(2,3); $j++){
                $genre = new Genre();
                $genre -> setName($faker->word())
                       -> setDescription($faker->paragraph());
                $manager -> persist ($genre);

                // Book
                for ($k = 0; $k < mt_rand(2, 4); $k++){
                    $book = new Book();
                    $book -> setTitle($faker->sentence())
                          -> setSummary($faker->paragraph())
                          -> setQuantity($faker->numberBetween(1, 33))
                          -> setPublishedDate($faker->dateTimeBetween('-15 years'))
                          -> setTypeId($type)
                          -> setGenreId($genre);
                    $manager -> persist($book);
                }    
            }
        }
        
        
        $manager->flush();
    }
}
