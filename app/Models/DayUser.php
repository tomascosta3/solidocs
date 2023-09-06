<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayUser extends Model
{
    use HasFactory;

    protected $table = 'day_user';

    protected $fillable = [
        'user_id',
        'day_id',
        'days_available',
        'active'
    ];
}
