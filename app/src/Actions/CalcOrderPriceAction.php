<?php

namespace App\Actions;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class CalcOrderPriceAction
{
    public function execute(Request $request, ProductRepository $productRepository):int
    {

        $price = 0;
        foreach ($request->request->get('products') as $product) {
            $productEntity = $productRepository->find($product['id']);
            $price += $productEntity->getPrice() * $product['count'];
        }
        return $price;
    }
}