<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Cita;
use App\Models\User;
use App\Models\CitasServicios;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $this->call([
            ServicioSeeder::class, 
        ]);

        Cita::factory(10)->create();
        CitasServicios::factory(10)->create();

    }
}
