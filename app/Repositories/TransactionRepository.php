<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;

class TransactionRepository
{
    public function getAll()
    {
        return DB::select('CALL sp_get_transactions()');
    }

    public function getById($id)
    {
        $client = DB::table('transactions')
            ->where('id', $id)
            ->first();

        if (!$client)
            throw new Exception('Transaction not founded.');

        return $client;
    }

    public function create($data): int
    {
        $amount    = $data['amount'];
        $date      = $data['date'];
        $client_id = $data['client_id'];

        $result = DB::select('CALL sp_insert_transaction(?, ?, ?)', [$amount, $date, $client_id]);

        $insertedId = $result[0]->inserted_id;

        return $insertedId;
    }

    public function update($id, $data)
    {
        return DB::table('transactions')
            ->where('id', $id)
            ->update($data);
    }

    public function delete($id)
    {
        return DB::table('transactions')
            ->where('id', $id)
            ->delete();
    }

    public function getTransactionsByClientId($id)
    {
        $clients = DB::table('transactions')
            ->where('client_id', $id)
            ->get();

        return $clients;
    }

    public function deleteTransactionsByClientId($id)
    {
        // Llamada al SP para eliminar las transacciones asociadas al cliente y obtener la cantidad de filas afectadas
        $result = DB::select('CALL sp_delete_transactions_by_client(?)', [$id]);

        // El número de filas afectadas estará en el primer elemento de la respuesta
        $affectedRows = $result[0]->affected_rows;

        return $affectedRows;
    }
}
