<?php

namespace App\Controller;

use App\Entity\DailyReport;
use App\Entity\ReportInterface;
use App\Repository\DailyReportRepository;
use App\Repository\MonthlyReportRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\WeeklyReportRepository;
use App\Services\ReportService;
use Carbon\Carbon;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    #[Route('/report/daily', name: 'report.daily')]
    public function daily(
        DailyReportRepository $repository,
    ): Response
    {
        return $this->json($repository->findAll());
    }
    #[Route('/report/weekly', name: 'report.weekly')]
    public function weekly(
        WeeklyReportRepository $repository,
    ): Response
    {
        return $this->json($repository->findAll());
    }

    #[Route('/report/monthly', name: 'report.monthly')]
    public function monthly(
        MonthlyReportRepository $repository,
    ): Response
    {
        return $this->json($repository->findAll());
    }

    #[Route('/report/daily/create', name: 'report.daily.create')]
    public function dailyCreate(DailyReportRepository $repository, ReportService $service): Response
    {
        $service->createDaily();
        return $this->json('Success created');
    }
    #[Route('/report/weekly/create', name: 'report.weekly.create')]
    public function weeklyCreate(ReportService $service): Response
    {
        $service->createWeekly();
        return $this->json('Success created');
    }
    #[Route('/report/monthly/create', name: 'report.monthly.create')]
    public function monthlyCreate(ReportService $service): Response
    {
        $service->createMonthly();
        return $this->json('Success created');
    }

}