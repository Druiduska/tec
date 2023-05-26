<?php

namespace App\Factories\Auth;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use App\Models\Staff\Staff;
use App\Models\Auth\User;
use App\Models\Auth\Access;

class AccessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Access::class;

    public function definition()
    {
        $time = Carbon::create($this->faker->dateTime);
        return [
            'login_at' => $time,
            'access_at' => $time->copy()->addMinutes($this->faker->numberBetween(0, 1440)),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}