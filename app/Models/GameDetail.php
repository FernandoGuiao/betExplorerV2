<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    function game(){
        return $this->belongsTo(Game::class);
    }
}
