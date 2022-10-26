<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Services\ReportService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    #[Route('/report/daily', name: 'report.daily')]
    public function index(OrderRepository $repository, ReportService $service): Response
    {
        $approvedOrders = $repository->getApprovedList();
        $service->getMonths($approvedOrders[0]->getApprovedAt(),$approvedOrders[count($approvedOrders)-1]->getApprovedAt());
        return $this->json($repository->getApprovedList());
    }
}