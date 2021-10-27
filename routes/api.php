<?php

use App\Http\Controllers\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return response()->json(['message' => 'ok']);
});
Route::get('cep/{address}', [AddressController::class, 'buscaCep'])->name('buscaCep');
