<?php

namespace App\Services;

use App\Repositories\ClientRepository;

class ClientService
{
    private $clientRepository;
    
    public function __construct(ClientRepository $clientRepository) 
    {
        $this->clientRepository = $clientRepository;
    }

    public function getAll()
    {
        return $this->clientRepository->getAll();
    }

    public function getById($id)
    {
        return $this->clientRepository->getById($id);
    }

    public function create($data)
    {
        return $this->clientRepository->create($data);
    }

    public function update($id, $data)
    {
        return $this->clientRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->clientRepository->delete($id);
    }
}