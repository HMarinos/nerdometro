<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    use HasFactory;
    protected $table = 'anime_list';
    protected $casts = [
        'genres' => 'array',
    ];

    protected $fillable = [
        'title',
        'genres',
        'date',
        'image_url',
        'db_id',
        'duration',
        'episodes'
    ];

    public function users(){
        return $this->belongsToMany(User::class,'anime_user');
    }

    public function wishlist(){
        return $this->belongsToMany(User::class,'anime_user_wishlist');
    }
}
