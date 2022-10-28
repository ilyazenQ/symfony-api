<?php
namespace App\Actions;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class CheckProductsRequestAction
{
    public function execute(Request $request, ProductRepository $productRepository) {

        foreach ($request->request->get('products') as $product) {

            if (!$productRepository->existsById($product['id'])) {
                throw new \Exception("Product not found");
            }
        }
    }
}