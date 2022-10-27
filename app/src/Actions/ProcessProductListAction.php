<?php

namespace App\Actions;

use App\Entity\Product;
use App\Model\ProductModel;
use Symfony\Component\HttpFoundation\Request;

class ProcessProductListAction
{
    public function execute(Request $request)
    {
        $page = $request->get('page', 1);
        $orderField = $request->get('order_field', 'id');
        $order = $request->get('order', 'ASC');

        if(!in_array($orderField, ProductModel::ORDER_FIELDS)) {
            throw new \Exception('Invalid sort field');
        }

        if(!in_array($order, ['ASC','DESC'])) {
            throw new \Exception('Invalid sort field');
        }
        return [
            'page'=>$page,
            'orderField'=>$orderField,
            'order'=>$order
        ];

    }
}