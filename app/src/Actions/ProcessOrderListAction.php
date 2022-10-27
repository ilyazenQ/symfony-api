<?php

namespace App\Actions;

use App\Entity\Product;
use App\Model\ProductModel;
use App\Model\ReportModel;
use Symfony\Component\HttpFoundation\Request;

class ProcessOrderListAction
{
    public function execute(Request $request)
    {
        $orderField = $request->get('order_field', 'id');
        $order = $request->get('order', 'ASC');

        if (!in_array($orderField, ReportModel::ORDER_FIELDS)) {
            throw new \Exception('Invalid sort field');
        }

        if (!in_array($order, ['ASC', 'DESC'])) {
            throw new \Exception('Invalid sort field');
        }

        return [
            'orderField' => $orderField,
            'order' => $order
        ];

    }
}