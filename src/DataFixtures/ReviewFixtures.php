<?php

namespace App\DataFixtures;

use App\Entity\Hotel;
use App\Entity\Review;
use Doctrine\Persistence\ObjectManager;

class ReviewFixtures extends BaseFixtures
{

    function loadData(ObjectManager $manager): void
    {

        $this->createMany(Review::class, 100000, function (Review $review) {

            /** @var Hotel $hotel */
            $hotel = $this->getReference(Hotel::class . '_' . $this->faker->numberBetween(0, 9));

            $review
                ->setHotel($hotel)
                ->setScore($this->faker->numberBetween(1, 10))
                ->setComment($this->faker->boolean() ? $this->faker->realText() : null)
                ->setCreatedDate($this->faker->dateTimeBetween('-2 year'));
        });
    }
}
