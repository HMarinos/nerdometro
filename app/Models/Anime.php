<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    use HasFactory;
    protected $table = 'anime_list';

    protected $fillable = [
        'title',
        'genre',
        'date',
        'image_url',
        'db_id'
    ];

    public function users(){
        return $this->belongsToMany(User::class,'anime_user');
    }

    public function wishlist(){
        return $this->belongsToMany(User::class,'anime_user_wishlist');
    }
}
