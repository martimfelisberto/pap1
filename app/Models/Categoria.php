<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Categoria extends Model
{
    /** @use HasFactory<\Database\Factories\CategoriasFactory> */
    use HasFactory;

    protected $fillable = [
        'titulo',
        'genero',
        'slug',
        'created_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($categoria) {
            $slugBase = strtolower(str_replace(' ', '-', $categoria->titulo));
            $categoria->slug = $slugBase . '-' . strtolower($categoria->genero);
        });
    }
    

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the produtos for the categoria.
     */
    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class, 'categoria_id');
    }

    /**
     * Get the user that created the categoria.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
