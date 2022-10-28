<?php

namespace App\Tests;

use App\Entity\Order;
use App\Entity\Product;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Helmich\JsonAssert\JsonAssertions;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractTestCase extends WebTestCase
{
    use JsonAssertions;

    protected KernelBrowser $client;

    protected ?EntityManagerInterface $em;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->em = self::getContainer()->get('doctrine.orm.entity_manager');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null;
    }

    protected function createOrder()
    {
        $order = new Order();
        $order->setPrice(1);
        $order->setTotalCount(1);
        $order->setApproved(true);
        $order->setApprovedAt(new Carbon());
        $order->setProducts([
            'id' => 1,
            "count" => 1,
            "price_unit" => 1
        ]);

        $this->em->persist($order);
        $this->em->flush();

        return $order;
    }

    protected function createDidntApproveOrder()
    {
        $order = new Order();
        $order->setPrice(1);
        $order->setTotalCount(1);
        $order->setApproved(false);
        $order->setApprovedAt(null);
        $order->setProducts([
            'id' => 1,
            "count" => 1,
            "price_unit" => 1
        ]);

        $this->em->persist($order);
        $this->em->flush();

        return $order;
    }

    public function createProduct()
    {
        $product = new Product();
        $product->setTitle('title');
        $product->setPrice(10);

        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }
}