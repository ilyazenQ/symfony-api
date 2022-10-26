<?php

namespace App\Services;

use Carbon\Carbon;
use Symfony\Component\Validator\Constraints\DateTime;

class ReportService
{
    public function getDays($begin, $end)
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

    public function getWeeks($begin, $end)
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

    public function getMonths($begin, $end)
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