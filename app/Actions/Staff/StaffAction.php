<?php

namespace App\Actions\Staff;

use App\Actions\Auth\AuthAction;

class StaffAction
{
    /**
     * @param array $staffList
     * @return array
     */
    public static function loadCSV(array $staffList)
    {
        $user = new \App\Models\Auth\User();
        $staff = new \App\Models\Staff\Staff();

        $notLoaded = [];
        foreach ($staffList as $item) {
            if ($user->where('name', $item[config('import.staff-csv.login')])->exists() ||
                $user->where('name', $item[config('import.staff-csv.email')])->exists()) {
                $notLoaded [] = $item;
                continue;
            }
            $userId = AuthAction::registration(
                name: $item[config('import.staff-csv.login')],
                email: $item[config('import.staff-csv.email')],
                password: $item[config('import.staff-csv.pass')]
            );
            $staff->create([
                'family' => $item[config('import.staff-csv.family')],
                'name' => $item[config('import.staff-csv.name')],
                'patronymic' => $item[config('import.staff-csv.patronymic')],
                'user_id' => $userId,
            ]);
        }
        return $notLoaded;
    }

    /**
     * @return array|array[]
     */
    public function index()
    {
        $staff = new \App\Models\Staff\Staff();

        $staffList = $staff->with('user')->get()->toArray();
        $resultList = array_map(function($item){
            return [
                'user_id' => $item['user_id'],
                'family' => $item['family'],
                'name' => $item['name'],
                'patronymic' => $item['patronymic'],
                'login' => $item['user']['name'],
                'email' => $item['user']['email'],
            ];
        }, $staffList);

        return $resultList;
    }
}