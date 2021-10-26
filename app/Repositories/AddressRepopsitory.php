<?php

namespace App\Repositories;

use App\Services\AddressService;

class AddressRepopsitory
{
    private $service;

    public function __construct(AddressService $service)
    {
        $this->service = $service;
    }

    public function buscaCep(string $cep)
    {
        return $this->service->buscaCep($cep);
    }
}
