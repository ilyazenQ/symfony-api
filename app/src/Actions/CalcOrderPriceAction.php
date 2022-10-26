<?php

namespace App\Actions;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class CalcOrderPriceAction
{
    public function execute(Request $request, ProductRepository $productRepository):int
    {
        $price = 0;
        $productsRequest = [];

        foreach ($request->request->get('products') as $k => $product) {
            $productEntity = $productRepository->find($product['id']);
            $productsRequest[$k] = $request->request->get('products')[$k];
            $productsRequest[$k] += ['price_unit' => $productEntity->getPrice()];
            $price += $productEntity->getPrice() * $product['count'];
        }

        $request->request->set('products',$productsRequest);

        return $price;
    }
}