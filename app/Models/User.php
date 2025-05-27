<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',
        'is_admin',
        
    ];
    
/**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
 /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // Garante que o valor seja tratado como booleano
        ];
    }

    /**
     * Check if the user is an admin
     *
     * @return bool
     */
    public function is_admin()
    {
        // Versão mais simples e robusta
        return (bool)($this->attributes['is_admin'] ?? false);
    }

    /**
     * Método alternativo para compatibilidade
     */
    public function isAdmin()
    {
        return $this->is_admin();
    }

    /**
     * Accessor para uso como propriedade
     */
    public function getIsAdminAttribute()
    {
        return $this->is_admin();
    }

    // No modelo User
public function produtos()
{
    return $this->hasMany(Produto::class);
}
/**
 * Get the user's favorite products
 */
public function favorites()
{
    return $this->hasMany(Favorite::class);
}

/**
 * Check if a product is favorited by this user
 */
public function hasFavorited($productId)
{
    return $this->favorites()->where('produto_id', $productId)->exists();
}
}