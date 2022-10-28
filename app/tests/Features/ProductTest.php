<?php

namespace App\Tests;

class ProductTest extends AbstractTestCase
{

    public function testIndex()
    {
        $this->client->request('GET', 'http://localhost:8081/products');

        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();

        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['result'],
            'properties' => [
                'result' => [
                    'type' => 'array',
                ],
                "numResult"=> [
                    'type' => 'integer',
                ],
                "currentPage"=> [
                    'type' => 'integer',
                ],
                "lastPage"=> [
                    'type' => 'integer',
                ],
                "pageSize"=> [
                    'type' => 'integer',
                ],
                "previousPage"=> [
                    'type' => 'integer',
                ],
                "nextPage"=> [
                    'type' => 'integer',
                ],
                "toPaginate"=> [
                    'type' => 'boolean',
                ]
            ],
        ]);
    }
}