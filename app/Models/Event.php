<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'calendar_id',
        'event_type_id',
        'title',
        'start',
        'end',
        'reminder',
        'reminder_sent',
        'location',
        'comment',
        'all_day',
        'active'
    ];


    /**
     * Return event's related calendar.
     */
    public function calendar() {

        return $this->belongsTo(Calendar::class);
    }


    /**
     * Return event type model related to this event.
     */
    public function event_type() {

        return $this->belongsTo(EventType::class);
    }


    /**
     * Return attached users, 
     */
    public function users() {
        return $this->belongsToMany(User::class);
    }
}
