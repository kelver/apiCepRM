<?php

namespace App\Services;

use App\Models\Address;
use Illuminate\Support\Facades\Http;

class AddressService
{
    private $entity;

    public function __construct(Address $address)
    {
        $this->entity = $address;
    }

    public function buscaCep(string $cep)
    {
        return $this->buscaGeral($cep);
    }

    public function buscaGeral(string $cep)
    {
        $buscaLocal = $this->entity->where('cep', $cep)->first();

        if(!$buscaLocal){
            $buscaLocal = $this->buscaRemota($cep);
        }

        return $buscaLocal;
    }

    public function buscaRemota(string $cep)
    {
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if($response->failed()){
            return ['Error' => 'Não foi possível verificar o cep informado.'];
        }
        $localData = $this->saveLocalData($response->json());

        return $localData;
    }

    public function saveLocalData($data)
    {
        $localData = $this->entity->create([
            'cep'         => $data['cep'],
            'logradouro'  => $data['logradouro'],
            'bairro'      => $data['bairro'],
            'cidade'      => $data['localidade'],
            'uf'          => $data['uf'],
        ]);
        return $localData;
    }
}
