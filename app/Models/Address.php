<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public $table = 'addresses';
    public $fillable = [
        'cep',
        'uuid',
        'logradouro',
        'bairro',
        'cidade',
        'uf'
    ];
    public $timestamps = true;
}
