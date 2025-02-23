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
        'genre',
        'date',
        'image_url',
        'db_id'
    ];

    public function users(){
        return $this->belongsToMany(User::class,'game_user');
    }
}
