<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movie = new Movie();
        $movie->setTitle('Big Man');
        $movie->setReleaseYear(2012);
        $movie->setDescription('MyMan');
        $movie->setImagePath('https://i.pinimg.com/originals/84/4a/8f/844a8f7edf8ba263367f008f5a6797d9.jpg');
        $movie->addActor($this->getReference('actor_1'));
        $movie->addActor($this->getReference('actor_2'));
        $manager->persist($movie);

        $movie2 = new Movie();
        $movie2->setTitle('Dude, Where\'s My Car?');
        $movie2->setReleaseYear(2019);
        $movie2->setDescription('He lost his car');
        $movie2->setImagePath('https://m.media-amazon.com/images/M/MV5BNzRmN2NjNzktOWE1My00NjVlLWFhNjYtZmFkMzM5YTA2ZTFlXkEyXkFqcGdeQXVyMTQxNzMzNDI@._V1_.jpg');
        $movie2->addActor($this->getReference('actor_3'));
        $movie2->addActor($this->getReference('actor_4'));
        $manager->persist($movie2);

        $manager->flush();
    }
}
