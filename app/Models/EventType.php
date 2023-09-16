<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;

    protected $table = 'event_types';

    protected $fillable = [
        'name'
    ];


    /**
     * Returns events that have this event type.
     */
    public function events() {

        return $this->hasMany(Event::class);
    }
}
