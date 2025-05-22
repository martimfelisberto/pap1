<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'produto_id',
        'nome_completo',
        'morada',
        'localidade',
        'cidade',
        'codigo_postal',
        'telefone',
        'pais',
        'email',
        'metodo_pagamento',
        'preco',
        'created_at' ,
        'updated_at',
        'user_id',
    ];
}
