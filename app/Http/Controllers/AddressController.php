<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressResource;
use App\Repositories\AddressRepopsitory;

class AddressController extends Controller
{
    private $repository;

    public function __construct(AddressRepopsitory $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function buscaCep(string $address)
    {
        $data = $this->repository->buscaCep($address);

        if(is_array($data) && array_key_exists('Error', $data)){
            return response()->json(['data' => $data], 422);
        }

        return AddressResource::collection($data);
    }
}
