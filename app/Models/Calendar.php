<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $table = 'calendars';

    protected $fillable = [
        'user_id',
        'group_id',
        'name',
        'active'
    ];


    /**
     * Returns related users.
     */
    public function users() {

        return $this->belongsToMany(User::class);
    }

    
    /**
     * Return group.
     */
    public function group() {

        return $this->belongsTo(Group::class);
    }


    /**
     * Returns calendar's related events.
     */
    public function events() {

        return $this->hasMany(Event::class);
    }


    /**
     * Returns user related events.
     */
    public function user_events($user_id) {

        $user_events = $this->events
            ->whereHas('users', function($query) use ($user_id) {
                $query->where('id', $user_id)
                    ->where('active', true);
            })
            ->where('active', true)
            ->get();

        return $user_events;
    }
}
