<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SpInsertClient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = '
        	CREATE DEFINER=`root`@`localhost` PROCEDURE `amg_backend`.`sp_insert_client`(
                IN p_name VARCHAR(255), -- Parámetro de entrada para el nombre del cliente
                IN p_email VARCHAR(255), -- Parámetro de entrada para el email
                IN p_phone VARCHAR(10)  -- Parámetro de entrada para el teléfono
            )
            BEGIN
                INSERT INTO clients (name, email, phone)
                VALUES (p_name, p_email, p_phone);
            
                SELECT LAST_INSERT_ID() AS inserted_id;
            END
    ';

        DB::unprepared('drop procedure if exists sp_insert_client');
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('drop procedure if exists sp_insert_client');
    }
}
