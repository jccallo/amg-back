<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Services\ClientService;
use App\Services\TransactionService;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    private $clientService;
    private $transactionService;

    public function __construct(ClientService $clientService, TransactionService $transactionService)
    {
        $this->clientService = $clientService;
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        return $this->successResponse($this->clientService->getAll());
    }

    public function show($id)
    {
        return $this->successResponse($this->clientService->getById($id));
    }

    public function store(ClientRequest $request)
    {
        // Recupera los datos del cliente y las transacciones
        $client = $request->only(['name', 'email', 'phone']);
        $transactions = $request->validated()['transactions'];

        // Comienza la transacción
        DB::beginTransaction();

        try {
            // Crea el cliente a través del SP
            $clientId = $this->clientService->create($client); // Asume que este método llama al SP y devuelve el ID del cliente

            // Si hay transacciones, crea cada una de ellas
            if (count($transactions) > 0) {
                foreach ($transactions as $transaction) {
                    $transaction['client_id'] = $clientId;  // Asocia el cliente a cada transacción
                    $this->transactionService->create($transaction);  // Llama al SP para insertar la transacción
                }
            }

            // Si todo fue exitoso, confirma la transacción
            DB::commit();

            // Retorna una respuesta exitosa
            return $this->successResponse('Client and transactions inserted successfully.');
        } catch (\Exception $e) {
            // Si algo sale mal, revierte todos los cambios
            DB::rollBack();

            // Retorna una respuesta de error
            return $this->errorResponse('Error inserting client and transactions.');
        }
    }

    public function update(ClientRequest $request, $id)
    {
        // Recuperar los datos del cliente y las transacciones
        $client = $request->only(['name', 'email', 'phone']);
        $transactions = $request->validated()['transactions'];

        // Iniciar una transacción
        DB::beginTransaction();

        try {
            // Actualizar el cliente
            $this->clientService->update($id, $client);

            // Eliminar las transacciones previas
            $this->transactionService->deleteTransactionsByClientId($id);

            // Si hay transacciones, insertarlas
            if (count($transactions) > 0) {
                foreach ($transactions as $value) {
                    $value['client_id'] = $id;
                    $this->transactionService->create($value);
                }
            }

            // Confirmar la transacción si todo fue exitoso
            DB::commit();

            return $this->successResponse('Client and transactions updated successfully.');
        } catch (\Exception $e) {
            // Si algo sale mal, revertir todos los cambios realizados
            DB::rollBack();

            // Opcionalmente, puedes devolver un mensaje de error detallado
            return $this->errorResponse('Error updating client and transactions.');
        }
    }

    public function destroy($id)
    {
        // Iniciar la transacción de base de datos
        DB::beginTransaction();

        try {
            // Eliminar las transacciones asociadas al cliente
            $this->transactionService->deleteTransactionsByClientId($id);

            // Eliminar el cliente
            $this->clientService->delete($id);

            // Confirmar la transacción si todo fue exitoso
            DB::commit();

            return $this->successResponse('Client and associated transactions deleted successfully.');
        } catch (\Exception $e) {
            // Si algo sale mal, revertir todos los cambios realizados
            DB::rollBack();

            // Retornar un error si ocurre algún problema
            return $this->errorResponse('An error occurred while deleting the client and associated transactions.');
        }
    }
}
