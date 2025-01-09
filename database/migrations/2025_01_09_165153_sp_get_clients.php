<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SpGetClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = '
            CREATE DEFINER=`root`@`localhost` PROCEDURE `amg_backend`.`sp_get_clients`()
            BEGIN
                SELECT 
                    c.id, 
                    c.name, 
                    c.email, 
                    c.phone,   
                    IFNULL(SUM(t.amount), 0) AS total_amount
                FROM clients c
                LEFT JOIN transactions t ON c.id = t.client_id
                GROUP BY c.id; -- Agrupa por el ID del cliente para calcular la suma del amount por cada cliente
            END
        ';

        DB::unprepared('drop procedure if exists sp_get_clients');
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('drop procedure if exists sp_get_clients');
    }
}
