<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;

class ClientRepository
{
    public function getAll()
    {
        return DB::select('CALL sp_get_clients()');;
    }

    public function getById($id)
    {
        $client = $client = DB::select('CALL sp_get_client_by_id(?)', [$id]);

        if (empty($client)) 
            throw new Exception('Client not founded.');

        return $client[0];
    }

    public function create($data): int
    {
        $name  = $data['name'];
        $email = $data['email'];
        $phone = $data['phone'];

        $result = DB::select('CALL sp_insert_client(?, ?, ?)', [$name, $email, $phone]);

        $insertedId = $result[0]->inserted_id;

        return $insertedId;
    }

    public function update($id, $data)
    {
        return DB::table('clients')
            ->where('id', $id)
            ->update($data);
    }

    public function delete($id)
    {
        // Llamar al procedimiento almacenado y obtener la cantidad de filas afectadas
        $result = DB::select('CALL sp_delete_client_by_id(?)', [$id]);

        // El número de filas afectadas estará en el primer elemento de la respuesta
        $affectedRows = $result[0]->affected_rows;

        return $affectedRows;
    }
}
