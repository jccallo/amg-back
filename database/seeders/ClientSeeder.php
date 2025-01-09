<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear una instancia de Faker
        $faker = Faker::create('es_ES');

        // Generar 10 registros de clientes
        for ($i = 0; $i < 5; $i++) {
            DB::table('clients')->insert([
                'name'       => $faker->name,                  // Genera un nombre aleatorio
                'email'      => $faker->unique()->safeEmail,   // Genera un correo único
                'phone'      => $faker->numerify('+1 (###) ###-####'), 
            ]);
        }
    }
}
