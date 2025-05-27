<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrinhoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'produto_id',
        'quantidade',
    ];

    /**
     * Get the user that owns the cart item
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product for this cart item
     */
    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
