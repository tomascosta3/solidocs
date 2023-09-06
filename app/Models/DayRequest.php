<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayRequest extends Model
{
    use HasFactory;

    protected $table = 'day_requests';

    protected $fillable = [
        'requested_by',
        'day_id',
        'requested_days',
        'status',
        'updated_by'
    ];
}
