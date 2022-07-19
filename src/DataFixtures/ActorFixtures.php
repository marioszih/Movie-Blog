<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $actor = new Actor();
        $actor->setName('Christian Bale');
        $actor->setBirthYear(1974);
        $actor->setImagePath('https://upload.wikimedia.org/wikipedia/commons/thumb/0/0d/Christian_Bale_2009.jpg/800px-Christian_Bale_2009.jpg');
        $manager->persist($actor);

        $actor2 = new Actor();
        $actor2->setName('Heath Ledger');
        $actor2->setBirthYear(1979);
        $actor2->setImagePath('https://upload.wikimedia.org/wikipedia/commons/thumb/e/ea/Heath_Ledger_%282%29.jpg/800px-Heath_Ledger_%282%29.jpg');
        $manager->persist($actor2);

        $actor3 = new Actor();
        $actor3->setName('Robert Downey Jr');
        $actor3->setBirthYear(1965);
        $actor3->setImagePath('https://m.media-amazon.com/images/M/MV5BNzg1MTUyNDYxOF5BMl5BanBnXkFtZTgwNTQ4MTE2MjE@._V1_UY1200_CR83,0,630,1200_AL_.jpg');
        $manager->persist($actor3);

        $actor4 = new Actor();
        $actor4->setName('Chris Evans');
        $actor4->setBirthYear(1981);
        $actor4->setImagePath('https://cdn.britannica.com/28/215028-050-94E9EA1E/American-actor-Chris-Evans-2019.jpg');
        $manager->persist($actor4);

        $manager->flush();

        $this->addReference('actor_1',$actor);
        $this->addReference('actor_2',$actor2);
        $this->addReference('actor_3',$actor3);
        $this->addReference('actor_4',$actor4);
    }
}
