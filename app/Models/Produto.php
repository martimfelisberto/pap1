<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nome
 * @property string $descricao
 * @property float $preco
 * @property string $marca
 * @property string $categoria
 * @property string $estado
 * @property string $tamanho
 * @property string $cores
 * @property string|null $imagem
 * @property boolean $destaque
 * @property string $genero
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read User $user
 */
class Produto extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'nome',
        'marca',
        'preco',
        'estado',
        'tamanho',
        'genero',
        'categoria',
        'imagem',
        'descricao',
        'user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'preco' => 'decimal:2'
    ];

    /**
     * Get the user that owns the product
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of the product
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Get the gender category of the product
     */
    public function generoRelation()
    {
        return $this->belongsTo(Genero::class, 'genero_id');
    }

    /**
     * Get the users who favorited this product
     */
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'produto_favorites', 'produto_id', 'user_id')->withTimestamps();
    }

    /**
     * Check if a product is favorited by user
     */
    public function isFavoritedByUser($userId)
    {
        return $this->favorites()->where('user_id', $userId)->exists();
    }

    /**
     * Get all product images
     */
    public function getImagesAttribute()
    {
        return $this->imagem ? json_decode($this->imagem, true) : [];
    }

    /**
     * Set product images
     */
    public function setImagesAttribute($value)
    {
        $this->attributes['imagem'] = json_encode($value);
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->preco, 2) . ' €';
    }
}