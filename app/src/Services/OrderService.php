<?php
namespace App\Services;

use App\Actions\CalcOrderPriceAction;
use App\Actions\CheckProductsRequestAction;
use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderService
{

    public function createOrder(
        Request $request,
        ProductRepository $productRepository,
        EntityManagerInterface $entityManager
    )
    {
        (new CheckProductsRequestAction())->execute($request, $productRepository);

        $order = new Order();
        $order->setPrice((new CalcOrderPriceAction())->execute($request, $productRepository));
        $order->setApproved(false);
        $order->setProducts($request->request->get('products'));

        $entityManager->persist($order);
        $entityManager->flush();

        return $order;
    }

    public function approveOrder(
        Request $request,
        OrderRepository $repository,
        EntityManagerInterface $entityManager,
    )
    {
        if(!$repository->existsById($request->get('id'))) {
            throw new \Exception('Order not found');
        }

        $order = $repository->find($request->get('id'));

        if($order->isApproved()) {
            throw new \Exception('Order already approved');
        }

        $order->setApproved(true);
        $order->setApprovedAt(new \DateTime());
        $entityManager->flush();

        return $order;
    }

    public function editOrder(
        Request $request,
        OrderRepository $repository,
        ProductRepository $productRepository,
        EntityManagerInterface $entityManager
    ) {
        (new CheckProductsRequestAction())->execute($request, $productRepository);

        $order = $repository->find($request->get('id'));

        if($order->isApproved()) {
            throw new \Exception('Cant change. Order approved');
        }

        $order->setPrice((new CalcOrderPriceAction())->execute($request, $productRepository));
        $order->setProducts($request->request->get('products'));

        $entityManager->persist($order);
        $entityManager->flush();

        return $order;
    }
}