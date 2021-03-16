<?php

namespace App\DataFixtures;

use App\Entity\Hotel;
use Doctrine\Persistence\ObjectManager;

class HotelFixtures extends BaseFixtures
{

    function loadData(ObjectManager $manager): void
    {
        $factory = fn(Hotel $hotel) => $hotel->setName($this->faker->lastName() . " Hotel");
        $this->createMany(Hotel::class, 10, $factory, true);
    }
}
