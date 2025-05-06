<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['title', 'content', 'genero_id'];

    public function genero()
    {
        return $this->belongsTo(Genero::class);
    }
}

class Genero extends Model
{
    protected $fillable = ['nome', 'slug'];

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
}