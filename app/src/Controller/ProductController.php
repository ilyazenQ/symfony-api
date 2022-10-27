<?php

namespace App\Controller;

use App\Actions\ProcessProductListAction;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    #[Route('/products', name: 'product.show')]
    public function index(ProductRepository $repository, Request $request, ProcessProductListAction $action): Response
    {
        return $this->json($repository->paginateProduct($action->execute($request)));
    }
}
