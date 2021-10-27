<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressResource;
use App\Repositories\AddressRepopsitory;
use Illuminate\Http\Request;

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
