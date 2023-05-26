<?php

namespace App\Factories\Auth;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Staff\Staff;
use App\Models\Auth\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
            'email' => $this->faker->unique()->safeEmail,
            'password' =>$this->faker->unique()->word(),
        ];
    }

}