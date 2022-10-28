<?php

namespace App\Tests;

use App\Entity\Order;
use Carbon\Carbon;

class ReportTest extends AbstractTestCase
{
    public function testCreate()
    {
        $this->client->request('GET', 'http://localhost:8081/report/monthly/create');

        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals('Success created', $responseContent);

        $this->client->request('GET', 'http://localhost:8081/report/daily/create');

        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals('Success created', $responseContent);

        $this->client->request('GET', 'http://localhost:8081/report/weekly/create');

        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals('Success created', $responseContent);

    }

    public function testMonthlyReport()
    {
        $order = $this->createOrder();

        $create = $this->client->request('GET', 'http://localhost:8081/report/monthly/create');

        $this->client->request('GET', 'http://localhost:8081/report/monthly');

        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();


//       $this->assertEquals($order->getId(),$responseContent[0]['orders'][0]['id']);
    }

    public function testDailyReport()
    {
        $order = $this->createOrder();

        $this->em->persist($order);
        $this->em->flush();

        $create = $this->client->request('GET', 'http://localhost:8081/report/daily/create');

        $this->client->request('GET', 'http://localhost:8081/report/daily');

        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();

//        $this->assertEquals($order->getId(),$responseContent[0]['orders'][0]['id']);
    }

    public function testWeeklyReport()
    {
        $order = $this->createOrder();

        $create = $this->client->request('GET', 'http://localhost:8081/report/weekly/create');

        $this->client->request('GET', 'http://localhost:8081/report/weekly');

        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();

//        $this->assertEquals($order->getId(),$responseContent[0]['orders'][0]['id']);
    }
}