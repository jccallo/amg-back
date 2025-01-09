<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SpGetTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = '
            CREATE DEFINER=`root`@`localhost` PROCEDURE `amg_backend`.`sp_get_transactions`()
            BEGIN
                SELECT 
                    t.id,
                    t.amount,
                    t.date,
                    c.id AS client_id,
                    c.name AS client_name,
                    c.email AS client_email,
                    c.phone AS client_phone
                FROM 
                    transactions t
                INNER JOIN 
                    clients c ON t.client_id = c.id
                ORDER BY 
                        t.id;
            END
        ';

        DB::unprepared('drop procedure if exists sp_get_transactions');
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('drop procedure if exists sp_get_transactions');
    }
}
