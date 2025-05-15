<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Categoria extends Model
{
    /** @use HasFactory<\Database\Factories\CategoriasFactory> */
    use HasFactory;

    protected $fillable = ['titulo', 'slug', 'genero', 'created_by'];

    /**
     * Get the user that created the categoria.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    /**
     * Set the slug attribute.
     */
    public function setSlugAttribute(string $value): void
    {
        $this->attributes['slug'] = \Illuminate\Support\Str::slug($value);
    }
    /**
     * Get the produtos for the categoria.
     */
    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class);
    }
    
}
