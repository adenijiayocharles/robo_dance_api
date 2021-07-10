<?php

namespace Database\Factories;

use App\Models\Manager;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManagerFactory extends Factory
{
    /**
     * The name of the factory"s corresponding model.
     *
     * @var string
     */
    protected $model = Manager::class;

    /**
     * Define the model"s default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "email" => $this->faker->unique()->safeEmail(),
            "email_verified_at" => now(),
            "password" => "password",
            "remember_token" => Str::random(10),
        ];
    }
}
