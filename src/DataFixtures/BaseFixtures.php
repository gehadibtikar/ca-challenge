<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

abstract class BaseFixtures extends Fixture
{
    const BATCH_SIZE = 10000;

    /** @var Generator */
    protected $faker;

    /** @var ObjectManager */
    protected $objectManager;

    public function __construct(EntityManagerInterface $em)
    {
        // Disable SQLLOgger to prevent memory exhaustion
        $em->getConnection()->getConfiguration()->setSQLLogger(null);
        $this->faker = Factory::create();
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->objectManager = $manager;

        $this->loadData($manager);
        $this->objectManager->flush();
    }

    protected function createMany(string $className, int $count, callable $factory, $addReference = false)
    {
        if($count > self::BATCH_SIZE) {
            printf("\033[33mFixtures will be inserted in %d batches. \033[0m\n", ceil($count / self::BATCH_SIZE));
        }

        for ($i = 0; $i < $count; $i++) {
            $entity = new $className();
            $factory($entity);
            $this->objectManager->persist($entity);
            if($addReference) {
                echo "reference added";
                $this->addReference($className . '_' . $i, $entity);
            }

            if ($i % self::BATCH_SIZE == 0 && $i != 0) {
                $this->objectManager->flush();
                $this->objectManager->clear();
            }
        }
    }

    /**
     * @param ObjectManager $manager
     */
    abstract function loadData(ObjectManager $manager):void;
}
