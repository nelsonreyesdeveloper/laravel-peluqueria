<?php

namespace Database\Factories;

use App\Models\Cita;
use App\Models\Servicio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CitasServicios>
 */
class CitasServiciosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cita_id' => Cita::all()->random()->id,
            'servicio_id' => Servicio::all()->random()->id,
            'cantidad' => $this->faker->numberBetween(1, 10),
            'subtotal' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
