<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear una instancia de Faker
        $faker = Faker::create();

        // Generar 10 registros de transacciones
        for ($i = 0; $i < 10; $i++) {
            DB::table('transactions')->insert([
                'amount'     => $faker->randomFloat(2, 1, 1000),   // Genera una cantidad aleatoria entre 1 y 1000 con 2 decimales
                'date'       => $faker->date(),                    // Genera una fecha aleatoria
                'client_id'  => rand(1, 5),
            ]);
        }

    }
}
