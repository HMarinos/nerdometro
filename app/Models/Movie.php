<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    protected $table = 'movies_list';
    protected $casts = [
        'genres' => 'array',
    ];

    protected $fillable = [
        'title',
        'genres',
        'date',
        'image_url',
        'db_id'
    ];

    public function users(){
        return $this->belongsToMany(User::class,'movie_user');
    }

    public function wishlist(){
        return $this->belongsToMany(User::class,'movie_user_wishlist');
    }
}
