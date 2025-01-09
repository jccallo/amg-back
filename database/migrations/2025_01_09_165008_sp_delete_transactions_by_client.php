<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SpDeleteTransactionsByClient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = '
            CREATE DEFINER=`root`@`localhost` PROCEDURE `amg_backend`.`sp_delete_transactions_by_client`(
                IN p_client_id INT  -- Parámetro de entrada para el ID del cliente
            )
            BEGIN
                -- Eliminar todas las transacciones asociadas al cliente
                DELETE FROM transactions
                WHERE client_id = p_client_id;

                -- Devolver la cantidad de filas afectadas
                SELECT ROW_COUNT() AS affected_rows;
            END
        ';

        DB::unprepared('drop procedure if exists sp_delete_transactions_by_client');
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('drop procedure if exists sp_delete_transactions_by_client');
    }
}
