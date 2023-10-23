<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\cita>
 */
class CitaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'user_id' => User::all()->random()->id,
           'fecha_cita' => fake()->date(),
           'hora_cita' => fake()->time(),
           'total' => fake()->randomFloat(2, 0, 100),
           'estado' => fake()->numberBetween(0, 1),
        ];
    }
}
