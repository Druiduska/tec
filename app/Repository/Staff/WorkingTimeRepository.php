<?php

declare(strict_types=1);

namespace App\Repository\Staff;

use App\Models\Auth\Access;
use App\Models\Staff\Staff;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class WorkingTimeRepository
{
    /**
     * @param int $user_id
     * @param $startDate
     * @param $endDate
     * @return array
     */
    public function byUser(int $user_id, $startDate, $endDate)
    {
        $working_time = Access::whereBetween('login_at', [$startDate, $endDate])
            ->whereUserId($user_id)
            ->sum(DB::raw('access_at - login_at'));
        $staff = Staff::whereUserId($user_id)->first();

        if ($working_time == 0) return [];

        return [
            'begin' => Carbon::create($startDate)->toDate()->format('Y-m-d'),
            'end' => Carbon::create($endDate)->toDate()->format('Y-m-d'),
            'family' => $staff->family,
            'name' => $staff->name,
            'patronymic' => $staff->patronymic,
            'working_time' => $working_time
        ];
    }
}

