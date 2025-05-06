<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Detalhe extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'nome',
        'quantidade',
        
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(related: categorias::class);
    }


}
