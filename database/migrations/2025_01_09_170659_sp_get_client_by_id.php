<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SpGetClientById extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = '
            CREATE DEFINER=`root`@`localhost` PROCEDURE `amg_backend`.`sp_get_client_by_id`(
            IN p_id INT -- Parámetro con prefijo para mayor claridad
            )
            BEGIN
                SELECT * 
                FROM clients
                WHERE id = p_id
                LIMIT 1; -- Asegura que solo se devuelva un registro
            END
        ';

        DB::unprepared('drop procedure if exists sp_get_client_by_id');
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('drop procedure if exists sp_get_client_by_id');
    }
}
