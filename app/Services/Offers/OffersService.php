<?php

namespace App\Services\Offers;

class OffersService
{

    public function createWithBoat(
        int    $user_id,
        string $name,
               $boats_types_id,
               $daily_price,
               $hourly_price
    )
    {
        $data = [
            'user_id' => $user_id,
            'name' => $name,
            'boats_types_id' => $boats_types_id,
            'daily_price' => $daily_price,
            'hourly_price' => $hourly_price
        ];
        return $data;

    }
}
