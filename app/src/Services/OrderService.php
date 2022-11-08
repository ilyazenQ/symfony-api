<?php

namespace App\Services;

use App\Actions\CalcOrderAttributeAction;
use App\Actions\CheckProductsRequestAction;
use App\Entity\Order;
use App\Model\OrderModel;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderService
{
    public function __construct(
        private ValidatorInterface $validator
    )
    {
    }

    public function createOrder(
        Request                $request,
        ProductRepository      $productRepository,
        EntityManagerInterface $entityManager,
    )
    {
        // Fill the order model
        $orderModel = new OrderModel();

        $orderModel->setProducts((array)$request->request->get('products'));
        $orderModel->setApproved($request->request->get('approved') ?? false);
        $orderModel->setApprovedAt($request->request->get('approved_at') ? new \DateTime($request->request->get('approved_at')) : null);

        (new CalcOrderAttributeAction())->execute($orderModel, $productRepository);

        // Fill the order entity
        $order = new Order();
        $order->setPrice($orderModel->getPrice());
        $order->setTotalCount($orderModel->getTotalCount());
        $order->setApproved($orderModel->getApproved());
        $order->setApprovedAt($orderModel->getApprovedAt());
        $order->setProducts($orderModel->getProducts());

        $this->validateOrderEntity($order);

        $entityManager->persist($order);
        $entityManager->flush();

        return $order;
    }

    public function approveOrder(
        Request                $request,
        OrderRepository        $repository,
        EntityManagerInterface $entityManager,
    )
    {
        $order = $repository->find($request->get('id'));

        $order->setApproved(true);
        $order->setApprovedAt(new \DateTime());
        $this->validateOrderEntity($order);

        $entityManager->persist($order);
        $entityManager->flush();

        return $order;
    }

    public function editOrder(
        Request                $request,
        OrderRepository        $repository,
        ProductRepository      $productRepository,
        EntityManagerInterface $entityManager
    )
    {
        $orderModel = new OrderModel();

        $orderModel->setProducts((array)$request->request->get('products'));
        $orderModel->setApproved($request->request->get('approved') ?? false);
        $orderModel->setApprovedAt($request->request->get('approved_at') ? new \DateTime($request->request->get('approved_at')) : null);

        (new CalcOrderAttributeAction())->execute($orderModel, $productRepository);

        $order = $repository->find($request->request->get('id'));

        $order->setPrice($orderModel->getPrice());
        $order->setTotalCount($orderModel->getTotalCount());
        $order->setProducts($orderModel->getProducts());

        $this->validateOrderEntity($order);

        $entityManager->persist($order);
        $entityManager->flush();

        return $order;
    }

    private function validateOrderEntity(Order $order)
    {
        $errors = $this->validator->validate($order);

        if (count($errors) > 0) {
            $errorsString = (string)$errors;
            return new Response($errorsString);
        }
    }
}
