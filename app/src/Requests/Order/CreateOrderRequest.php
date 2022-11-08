<?php

namespace App\Requests\Order;

use App\Model\OrderModel;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateOrderRequest
{
    protected array $errors = [];
    protected bool $status;

    public function __construct()
    {
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    public function hasErrors(): bool
    {
        return !$this->status;
    }

    /**
     * @param bool $status
     */
    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    protected function violations()
    {
        if (count($this->getErrors()) > 0) {
            $this->setStatus(false);
            return;
        }
        $this->setStatus(true);
    }

    public function errorResponse()
    {
        return ([
            'message' => 'Request validation errors',
            'errors' => $this->errors
        ]);
    }

    public function inputValidate(Request $request, $productRepository)
    {
        if (!$request->request->get('products')) {
            $this->errors [] = "Key products is required";
            return;
        }

        foreach ($request->request->get('products') as $product) {

            if (!$productRepository->existsById($product['id'])) {
                $this->errors [] = "Product with id {$product['id']} not found";
            }
        }

    }

    public function validate(Request $request, $productRepository)
    {
        $this->inputValidate($request, $productRepository);

        $this->violations();

        return $this;
    }

}