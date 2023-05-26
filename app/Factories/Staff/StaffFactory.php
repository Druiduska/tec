<?php

namespace App\Factories\Staff;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Staff\Staff;
use App\Models\Auth\User;

class StaffFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Staff::class;

    public function definition()
    {
        return [
            'family' =>$this->faker->lastName(),
            'name'  =>  $this->faker->firstName(),
            'patronymic' =>$this->faker->firstName(),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}