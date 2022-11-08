<?php

namespace App\Actions;

use App\Model\OrderModel;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class CalcOrderAttributeAction
{
    public function execute(OrderModel &$orderModel, ProductRepository $productRepository): void
    {
        $price = 0;
        $totalCount = 0;
        $productsRequest = [];

        foreach ($orderModel->getProducts() as $k => $product) {
            $totalCount += $product['count'];
            $productEntity = $productRepository->find($product['id']);
            $productsRequest[$k] = $orderModel->getProducts()[$k];
            $productsRequest[$k] += ['price_unit' => $productEntity->getPrice()];
            $price += $productEntity->getPrice() * $product['count'];
        }

        $orderModel->setProducts($productsRequest);
        $orderModel->setTotalCount($totalCount);
        $orderModel->setPrice($price);
    }
}