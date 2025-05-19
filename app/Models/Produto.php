<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'marca',
        'preco',
        'tamanho',
        'tamanhosapatilhas',
        'quantidade',
        'estado',
        'cores',
        'cores.*',
        'imagem',
        'tipo_produto',
        'tipo_sola',
        'medidas',
        'categoria',
        'genero',
        'created_at' ,
        'updated_at',
    ];

    protected $casts = [
        'cores' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
public function favorites()
    {
        return $this->hasMany(Favorite::class);
        


    }
    /**
     * Get the user that owns the product
     */
  
    /**
     * Get the category of the product
     */
    /**
     * Get the product's image URL
     */
    public function getImageUrlAttribute()
    {
        if (!$this->imagem) {
            return asset('images/default-product.jpg');
        }
        return asset('storage/produtos/' . $this->imagem);
    }
}