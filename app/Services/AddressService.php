<?php

namespace App\Services;

use App\Models\Address;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AddressService
{
    private $entity;

    public function __construct(Address $address)
    {
        $this->entity = $address;
    }

    public function buscaCep(string $address)
    {
        return $this->buscaGeral($address);
    }

    public function buscaGeral(string $address)
    {
        $address = $this->trataInfo($address);

        if(!is_array($address)){
            $buscaLocal = $this->entity->where('cep', $address)->take(1)->get();

            if($buscaLocal->isEmpty()){
                $buscaLocal = $this->searchCepRemote($address);
            }
            return $buscaLocal;
        }
        $buscaFull = $this->searchTextRemote($address);

        return $buscaFull;
    }

    public function searchCepRemote(string $address)
    {
        $response = Http::withHeaders([
                        'Accept' => 'application/json'
                    ])->get("http://cep.la/$address");

        if($response->failed() || is_null($response->json())){
            return ['Error' => 'Não foi possível verificar o cep informado.'];
        }
        $localData = $this->saveLocalData($response->json());

        return $localData;
    }

    public function searchFullText(array $address)
    {
        $data = Address::whereFuzzy('logradouro', $address['address'])
            ->orderBy('relevance_logradouro', 'desc')
            ->get();

        if($data->isEmpty()){
            $localData = $this->searchTextRemote($address);

            return $localData;
        }
        return $data;
    }

    public function searchTextRemote(array $address)
    {
        $response = Http::withHeaders([
                        'Accept' => 'application/json'
                    ])->get("http://cep.la/api/{$address['address']}");

        if($response->failed() || is_null($response->json())){
            return ['Error' => 'Não foi possível verificar o cep informado.'];
        }
        $localData = $this->saveLocalMultiData($response->json());

        return $localData;
    }

    public function saveLocalData($data)
    {
        $localData = $this->entity->create([
            'cep'         => $data['cep'],
            'logradouro'  => $data['logradouro'],
            'bairro'      => $data['bairro'],
            'cidade'      => $data['cidade'],
            'uf'          => $data['uf']
        ]);
        $data = $this->entity->where('id', $localData->id)->take(1)->get();

        return $data;
    }

    public function saveLocalMultiData($data)
    {
        $fullData = [];
        foreach ($data as $d){
            $localData = $this->entity->create([
                'cep' => $d['cep'],
                'logradouro' => $d['logradouro'],
                'bairro' => $d['bairro'],
                'cidade' => $d['cidade'],
                'uf' => $d['uf'],
            ]);

            array_push($fullData, $localData);
        }

        return $fullData;
    }

    public function trataInfo($info)
    {
        // valida se cep ou endereço
        if(!preg_match('/^[0-9]{5,5}([- ]?[0-9]{3,3})?$/', $info)) {
            return ['address' => Str::slug($info)];
        }

        return str_replace('-', '', $info);
    }
}
