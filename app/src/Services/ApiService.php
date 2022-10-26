<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Request;

class ApiService
{
    public function transformJsonBody(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}