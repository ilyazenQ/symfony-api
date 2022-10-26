<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {


        for ($i = 0; $i < 10; $i++) {
            $customer = new Product();
            $customer->setTitle('testname');
            $customer->setPrice($i + 20);
            $manager->persist($customer);
        }

        $manager->flush();
    }
}
