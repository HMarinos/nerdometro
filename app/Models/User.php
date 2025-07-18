<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function anime(){
        return $this->belongsToMany(Anime::class,'anime_user');
    }

    public function animeWishlist(){
        return $this->belongsToMany(Anime::class, 'anime_user_wishlist');
    }

    public function movieWishlist(){
        return $this->belongsToMany(Movie::class, 'movie_user_wishlist');
    }

    public function gameWishlist(){
        return $this->belongsToMany(Game::class,'game_user_wishlist');
    }

    public function movie(){
        return $this->belongsToMany(Movie::class,'movie_user');
    }
    
    public function game(){
        return $this->belongsToMany(Game::class,'game_user');
    }
}
