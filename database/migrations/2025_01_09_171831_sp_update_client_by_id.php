<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SpUpdateClientById extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = '
        	CREATE DEFINER=`root`@`localhost` PROCEDURE `amg_backend`.`sp_update_client_by_id`(
                IN p_id INT,              -- Parámetro de entrada para el id del cliente
                IN p_name VARCHAR(255),   -- Parámetro de entrada para el nuevo nombre
                IN p_email VARCHAR(255),  -- Parámetro de entrada para el nuevo email
                IN p_phone VARCHAR(50)    -- Parámetro de entrada para el nuevo teléfono
            )
            BEGIN
                UPDATE clients
                SET name = p_name, 
                    email = p_email, 
                    phone = p_phone
                WHERE id = p_id;
            END
    ';

        DB::unprepared('drop procedure if exists sp_update_client_by_id');
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('drop procedure if exists sp_update_client_by_id');
    }
}
