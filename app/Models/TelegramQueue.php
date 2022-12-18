<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramQueue extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'telegram_queue';
}
