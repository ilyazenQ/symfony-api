<?php

namespace App\Requests\Order;

use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;

class ApproveOrderRequest extends EditOrderRequest
{
    public function inputValidate(Request $request, $productRepository)
    {
        if (!$request->get('id')) {
            $this->errors [] = "Key id is required";
            return;
        }

        $order = $this->orderRepository->find($request->get('id'));

        if (!$order) {
            $this->errors [] = "Order not found";
            return;
        }

        if ($order->isApproved()) {
            $this->errors [] = "Order already approved";
            return;
        }
    }

}