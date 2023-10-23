<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('servicios')->insert([
            [
                'nombre' => 'Pack Corte de Pelo + Corte de Barba',
                'precio' => 4,
                'descripcion' => 'Conjunto de corte de pelo y corte de barba al gusto del cliente',
                'text_imagen' => 'corte_barba_pelo_hombre'
            ],
            [
                'nombre' => 'Corte de pelo hombre',
                'precio' => 3,
                'descripcion' => 'Corte de pelo para hombre al gusto del cliente',
                'text_imagen' => 'corte_pelo_hombre'
            ],
            [
                'nombre' => 'Corte de Barba',
                'precio' => 2,
                'descripcion' => 'Corte de barba para hombre al gusto del cliente',
                'text_imagen' => 'corte_barba_hombre'
            ],
            [
                'nombre' => 'Corte de Niño',
                'precio' => 2,
                'descripcion' => 'Corte para niño al gusto del cliente',
                'text_imagen' => 'corte_niño'
            ],
            [
                'nombre' => 'Corte de Cejas, Hombre y Mujer',
                'precio' => 2,
                'descripcion' => 'Corte y limpieza de cejas al gusto del cliente',
                'text_imagen' => 'corte_cejas'
            ],
        ]);
    }
}
