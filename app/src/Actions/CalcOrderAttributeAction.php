<?php

namespace App\Actions;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class CalcOrderAttributeAction
{
    public function execute(Request $request, ProductRepository $productRepository):void
    {

        $price = 0;
        $totalCount = 0;
        $productsRequest = [];

        foreach ($request->request->get('products') as $k => $product) {

            $totalCount += $product['count'];
            $productEntity = $productRepository->find($product['id']);
            $productsRequest[$k] = $request->request->get('products')[$k];
            $productsRequest[$k] += ['price_unit' => $productEntity->getPrice()];
            $price += $productEntity->getPrice() * $product['count'];
        }

        $request->request->set('products',$productsRequest);
        $request->request->set('total_count',$totalCount);
        $request->request->set('price',$price);

    }
}