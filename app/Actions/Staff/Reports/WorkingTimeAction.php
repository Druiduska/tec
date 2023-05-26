<?php

declare(strict_types=1);

namespace App\Actions\Staff\Reports;

use Illuminate\Support\Carbon;
use App\Repository\Staff\WorkingTimeRepository;

class WorkingTimeAction
{
    /**
     * @param WorkingTimeRepository $workingTimeRepository
     */
    public function __construct(protected WorkingTimeRepository $workingTimeRepository)
    {
    }

    /**
     * @param $user_id
     * @param $date
     * @param $count
     * @return array
     */
    public function byWeek(int $user_id, string $date, int $count = 1)
    {
        $now = Carbon::create($date);
        $tomorrow = $now->copy()->addDays(1);
        $weekStart = $now->copy()->addDays(1 - $now->dayOfWeekIso);
        $weekEnd = $now->copy()->addDays(7 - $now->dayOfWeekIso);
        $weeksReport = [];
        $weekStart->addWeek(1 - $count);
        $weekEnd->addWeek(1 - $count);
//dd($weekStart->copy(), $weekEnd->copy());
        for ($i = 0; $i < $count; $i++) {
            if ($itemReport = $this->workingTimeRepository->byUser($user_id, $weekStart->copy(), $weekEnd->copy()))
                $weeksReport [] = $itemReport;
            $weekStart->addWeek(1);
            $weekEnd->addWeek(1);
        }
//        if ($itemReport = $this->workingTimeRepository->byUser($user_id, $weekStart->copy(), $tomorrow->copy()))
//            $weeksReport [] = $itemReport;

        return $weeksReport;
    }
}

