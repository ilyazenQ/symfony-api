<?php

namespace App\Controller;

use App\Actions\CalcOrderAttributesAction;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Services\ApiService;
use App\Services\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
        private ApiService        $apiService,
    )
    {
    }

    #[Route('/orders', name: 'order.index')]
    public function index(OrderRepository $repository): Response
    {
        return $this->json($repository->findAll());
    }

    #[Route('/order/new/', name: 'order.new', methods: ['POST'])]
    public function add(
        Request                $request,
        EntityManagerInterface $entityManager,
        OrderService           $service,
    ): JsonResponse
    {
        $request = $this->apiService->transformJsonBody($request);
        return $this->json($service->createOrder($request, $this->productRepository, $entityManager), 201);
    }

    #[Route('/order/edit/', name: 'order.edit', methods: ['PATCH'])]
    public function edit(
        Request                $request,
        EntityManagerInterface $entityManager,
        OrderRepository        $repository,
        OrderService           $service,
    ): JsonResponse
    {
        $request = $this->apiService->transformJsonBody($request);
        return $this->json($service->editOrder($request, $repository, $this->productRepository, $entityManager), 200);
    }

    #[Route('/order/{id}/approve/', name: 'order.approve', methods: ['GET'])]
    public function approve(
        Request                $request,
        EntityManagerInterface $entityManager,
        OrderRepository        $repository,
        OrderService           $service,
    ): JsonResponse
    {
        return $this->json($service->approveOrder($request, $repository, $entityManager), 200);
    }
}
