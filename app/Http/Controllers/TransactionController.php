<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        return $this->successResponse($this->transactionService->getAll());
    }

    public function show($id)
    {
        return $this->successResponse($this->transactionService->getById($id));
    }

    public function store(TransactionRequest $request)
    {
        $this->transactionService->create($request->validated()); 
        return $this->successResponse('Transaction inserted.');
    }

    public function update(TransactionRequest $request, $id)
    {
        $this->transactionService->update($id, $request->validated());
        return $this->successResponse('Transaction updated.');
    }

    public function destroy($id)
    {
        $this->transactionService->delete($id);
        return $this->successResponse('Transaction deleted.');
    }

    public function getTransactionsByClientId($id)
    {
        return $this->successResponse($this->transactionService->getTransactionsByClientId($id));
    }

    public function deleteTransactionsByClientId($id)
    {
        return $this->successResponse($this->transactionService->deleteTransactionsByClientId($id));
    }
}
