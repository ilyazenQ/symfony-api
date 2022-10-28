<?php

namespace App\Services;

use App\Entity\DailyReport;
use App\Repository\OrderRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class ReportService
{
    private array $approvedOrders;

    public function __construct(
        private OrderRepository        $repository,
        private EntityManagerInterface $entityManager,

    )
    {
        $this->approvedOrders = $repository->getApprovedList();
    }

    private function reportProcessing(
        $interval,
        EntityManagerInterface $entityManager,
        $reportClassName
    )
    {
        $approvedOrders = $this->approvedOrders;

        $groupedOrders = [];

        // Distribution within the interval
        foreach ($approvedOrders as $orderKey => $order) {
            $orderDate = $order->getApprovedAt();

            foreach ($interval as $dayKey => $day) {
                $begin = Carbon::parse($day['start']);
                $end = Carbon::parse($day['end']);

                if ($orderDate >= $begin && $orderDate < $end) {
                    $groupedOrders[
                        "{$begin->toDateTimeString()} - {$end->toDateTimeString()}"
                    ][] = $order;
                }
            }
        }

        //Get total count and total price from interval and fill the database
        $totalCount = 0;
        $totalPrice = 0;
        foreach ($groupedOrders as $groupedOrdersKey => $orders) {
            foreach ($orders as $order) {
                $totalCount += $order->getTotalCount();
                $totalPrice += $order->getPrice();
            }

            $groupedOrders[$groupedOrdersKey]['total_count'] = $totalCount;
            $groupedOrders[$groupedOrdersKey]['total_price'] = $totalPrice;

            $report = new $reportClassName();
            $report->setOrders($orders);
            $report->setTitle($groupedOrdersKey);
            $report->setTotalCount($totalCount);
            $report->setTotalPrice($totalPrice);

            $entityManager->persist($report);
            $entityManager->flush();

            $totalCount = 0;
            $totalPrice = 0;
        }

    }

    public function createDaily(): void
    {
        $approvedOrders = $this->approvedOrders;
        $interval = $this->getDays($approvedOrders[0]->getApprovedAt(), $approvedOrders[count($approvedOrders) - 1]->getApprovedAt());
        $this->deleteReport('daily_report', $this->entityManager);
        $this->reportProcessing($interval, $this->entityManager, 'App\Entity\DailyReport');
    }

    public function createWeekly(): void
    {
        $approvedOrders = $this->approvedOrders;
        $interval = $this->getWeeks($approvedOrders[0]->getApprovedAt(), $approvedOrders[count($approvedOrders) - 1]->getApprovedAt());
        $this->deleteReport('weekly_report', $this->entityManager);
        $this->reportProcessing($interval, $this->entityManager, 'App\Entity\WeeklyReport');
    }

    public function createMonthly(): void
    {
        $approvedOrders = $this->approvedOrders;
        $interval = $this->getMonths($approvedOrders[0]->getApprovedAt(), $approvedOrders[count($approvedOrders) - 1]->getApprovedAt());
        $this->deleteReport('monthly_report', $this->entityManager);
        $this->reportProcessing($interval, $this->entityManager, 'App\Entity\MonthlyReport');
    }

    private function deleteReport(string $tableName, EntityManagerInterface $entityManager,
    )
    {
        $connection = $entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();

        $connection->executeUpdate($platform->getTruncateTableSQL($tableName, true));
    }


    private function getDays($begin, $end)
    {
        $datetime1 = new Carbon($begin->format('d-m-Y'));
        $datetime2 = new Carbon($end->format('d-m-Y'));
        $interval = date_diff($datetime1, $datetime2);


        for ($i = 0; $i <= $interval->days; $i++) {
            $arr[$i] = [
                'start' => $datetime1->toDateTimeString(),
                'end' => $datetime1->modify('+1 day')->toDateTimeString()
            ];

        }

        return $arr;
    }

    private function getWeeks($begin, $end)
    {
        $datetime1 = new Carbon($begin->format('d-m-Y'));
        $datetime2 = new Carbon($end->format('d-m-Y'));

        $WeekEnd = new Carbon($begin->format('d-m-Y'));
        $WeekEnd->endOfWeek();
        $arr = [
            [
                'start' => $datetime1->toDateTimeString(),
                'end' => $WeekEnd->toDateTimeString()
            ],

        ];

        $interval = $WeekEnd->diff($datetime2);

        for ($i = 0; $i <= floor($interval->days / 7); $i += 1) {
            $arr[$i + 1] = [
                'start' => $WeekEnd->toDateTimeString(),
                'end' => $WeekEnd->modify('+1 second')->modify('+1 week')->toDateTimeString()
            ];
        }

        return $arr;

    }

    private function getMonths($begin, $end)
    {
        $datetime1 = new Carbon($begin->format('d-m-Y'));
        $datetime2 = new Carbon($end->format('d-m-Y'));

        $WeekEnd = new Carbon($begin->format('d-m-Y'));
        $WeekEnd->endOfMonth();

        $arr = [
            [
                'start' => $datetime1->toDateTimeString(),
                'end' => $WeekEnd->toDateTimeString()
            ],

        ];

        $interval = $WeekEnd->diff($datetime2);

        for ($i = 0; $i <= floor($interval->days / 30); $i += 1) {

            $arr[$i + 1] = [
                'start' => $WeekEnd->toDateTimeString(),
                'end' => $WeekEnd->modify('+1 second')->modify('+1 month')->toDateTimeString()
            ];

        }
        return $arr;
    }


}