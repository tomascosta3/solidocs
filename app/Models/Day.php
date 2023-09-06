<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $table = 'days';

    protected $fillable = [
        'type',
        'default_amount',
        'reset_date',
        'active',
    ];
}
