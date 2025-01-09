<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SpInsertTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = 'CREATE PROCEDURE sp_insert_transaction(
            IN p_amount DECIMAL(10, 2),  -- Parámetro de entrada para el monto
            IN p_date DATE,              -- Parámetro de entrada para la fecha
            IN p_client_id INT           -- Parámetro de entrada para el ID del cliente
        )
        BEGIN
            -- Insertar la transacción con el monto, fecha y el client_id
            INSERT INTO transactions (amount, date, client_id)
            VALUES (p_amount, p_date, p_client_id);

            -- Devolver el ID de la transacción recién insertada
            SELECT LAST_INSERT_ID() AS inserted_id;
        END';

        DB::unprepared('drop procedure if exists sp_insert_transaction');
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('drop procedure if exists sp_insert_transaction');
    }
}
