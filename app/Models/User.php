<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail

{

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',
        'is_admin',
        'is_banned'
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

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
        'is_banned' => 'boolean'
    ];
    public function produtos()
    {
        return $this->hasMany(Produto::class, 'autor_id');
    }
 public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Helper methods
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    public function isBanned(): bool
    {
        return $this->is_banned === true;
    }

    public function favoriteProdutos()
    {
        return $this->belongsToMany(Produto::class, 'favorites', 'user_id', 'produto_id')
                ->withTimestamps();
    }

    
}
