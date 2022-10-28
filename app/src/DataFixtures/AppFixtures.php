<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\Product;
use Carbon\Carbon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $productIds = [];
        $productPrices = [];

        for ($i = 0; $i < 100; $i++) {
            $product = new Product();
            $product->setTitle('product ' . $i);
            $product->setPrice(mt_rand(10, 100));
            $manager->persist($product);
            $manager->flush();
            $productIds[$product->getId()] = $product->getId();
            $productPrices[$product->getId()] = $product->getPrice();
        }
        $dateBegin = new Carbon();
        for ($i = 0; $i < 500; $i++) {
            $count1 = mt_rand(1, 10);
            $count2 = mt_rand(1, 10);
            $id1 = array_rand($productIds, 1);
            $id2 = array_rand($productIds, 1);

            $order = new Order();
            $order->setApproved(true);
            $order->setApprovedAt($dateBegin->addHours($i));
            $order->setProducts([
                    [
                        'id' => $id1,
                        'count' => $count1,
                        'price_unit' => $productPrices[$id1]
                    ],
                    [
                        'id' => $id2,
                        'count' => $count2,
                        'price_unit' => $productPrices[$id2]
                    ],
                ]
            );
            $order->setPrice($count1 * $productPrices[$id1] + $count2 * $productPrices[$id2]);
            $order->setTotalCount($count1+$count2);

            $manager->persist($order);
            $manager->flush();
        }

    }
}
