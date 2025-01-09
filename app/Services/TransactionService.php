<?php

namespace App\Services;

use App\Repositories\TransactionRepository;

class TransactionService
{
    private $transactionRepository;
    
    public function __construct(TransactionRepository $transactionRepository) 
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function getAll()
    {
        return $this->transactionRepository->getAll();
    }

    public function getById($id)
    {
        return $this->transactionRepository->getById($id);
    }

    public function create($data)
    {
        return $this->transactionRepository->create($data);
    }

    public function update($id, $data)
    {
        return $this->transactionRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->transactionRepository->delete($id);
    }

    public function getTransactionsByClientId($id)
    {
        return $this->transactionRepository->getTransactionsByClientId($id);
    }

    public function deleteTransactionsByClientId($id)
    {
        return $this->transactionRepository->deleteTransactionsByClientId($id);
    }
}