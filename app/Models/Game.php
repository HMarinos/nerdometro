<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $table = 'games_list';

    protected $fillable = [
        'title',
        'genres',
        'date',
        'image_url',
        'db_id'
    ];

    public function users(){
        return $this->belongsToMany(User::class,'game_user');
    }

    public function wishlist(){
        return $this->belongsToMany(User::class,'game_user_wishlist');
    }
}
