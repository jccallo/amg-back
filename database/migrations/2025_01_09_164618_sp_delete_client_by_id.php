<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SpDeleteClientById extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = '
            CREATE DEFINER=`root`@`localhost` PROCEDURE `amg_backend`.`sp_delete_client_by_id`(
                IN p_id INT -- Parámetro de entrada para el id del cliente a eliminar
            )
            BEGIN
                -- Eliminar el cliente por su ID
                DELETE FROM clients
                WHERE id = p_id;

                -- Devolver la cantidad de filas afectadas
                SELECT ROW_COUNT() AS affected_rows;
            END
        ';

        DB::unprepared('drop procedure if exists sp_delete_client_by_id');
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('drop procedure if exists sp_delete_client_by_id');
    }
}
