<?php

namespace App\Tests;

use App\Entity\Order;
use App\Entity\Product;

class OrderTest extends AbstractTestCase
{
    public function testIndex()
    {
        $order = $this->createOrder();

        $this->client->request('GET', 'http://localhost:8081/orders');

        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'array',
            'properties' => [
                'approvedAt' => [
                    'type' => 'null',
                ],
                "id" => [
                    'type' => 'integer',
                ],
                "Products" => [
                    'type' => 'Array',
                ],
                "totalCount" => [
                    'type' => 'integer',
                ],
                "price" => [
                    'type' => 'integer',
                ],
                "approved" => [
                    'type' => 'boolean',
                ]
            ],
        ]);
    }

    public function testAdd()
    {
        $product = $this->createProduct();

        $this->client->request('POST', 'http://localhost:8081/order/new/',
            [
                "products" => [
                    [
                        "id" => $product->getId(),
                        "count" => 3
                    ],
                ]
            ]);


        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals($responseContent['price'], 30);
        $this->assertEquals($responseContent['approved'], false);
        $this->assertEquals($responseContent['totalCount'], 3);
    }

    public function testEdit()
    {
        $order = $this->createDidntApproveOrder();

        $product = $this->createProduct();

        $this->client->request('PATCH', 'http://localhost:8081/order/edit/',
            [
                "id" => $order->getId(),
                'products' => [
                    [
                        "id" => $product->getId(),
                        "count" => 10
                    ]
                ],
            ]);


        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals($responseContent['price'], 100);
        $this->assertEquals($responseContent['approved'], false);
        $this->assertEquals($responseContent['totalCount'], 10);
    }

    public function testApprove()
    {
        $order = $this->createDidntApproveOrder();

        $this->client->request('GET', "http://localhost:8081/order/{$order->getId()}/approve/");

        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals($responseContent['approved'], true);
    }

}