<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'identify'        => $this->uuid,
            'cep'             => substr_replace($this->cep, '-', -3, 0),
            'logradouro'      => $this->logradouro,
            'bairro'          => $this->bairro,
            'cidade'          => $this->cidade,
            'uf'              => $this->uf,
        ];
    }
}
