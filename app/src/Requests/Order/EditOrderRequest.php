<?php

namespace App\Requests\Order;

use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;

class EditOrderRequest extends CreateOrderRequest
{
    function __construct(
        protected OrderRepository $orderRepository
    )
    {
        parent::__construct();
    }

    public function inputValidate(Request $request, $productRepository)
    {
        parent::inputValidate($request, $productRepository);

        if (!$request->request->get('id')) {
            $this->errors [] = "Key id is required";
            return;
        }

        $order = $this->orderRepository->find($request->request->get('id'));

        if (!$order) {
            $this->errors [] = "Order not found";
            return;
        }

        if ($order->isApproved()) {
            $this->errors [] = "Cant change. Order approved";
            return;
        }

    }
}