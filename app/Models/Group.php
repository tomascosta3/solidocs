<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    
    protected $table = 'groups';

    protected $fillable = [
        'name',
        'description',
        'color',
        'active',
    ];


    /**
     * Gets the users who belong to the group.
     */
    public function users() {
        return $this->belongsToMany(User::class)->where('users.active', true)->withPivot('role')->withTimestamps();
    }


    /**
     * Gets user's count.
     */
    public function users_count() {

        return $this->belongsToMany(User::class)->where('users.active', true)->count();
    }


    /**
     * Return group's calendar.
     */
    public function calendar() {

        return $this->hasOne(Calendar::class);
    }


    /**
     * Return group's folders.
     */
    public function folders() {

        return $this->belongsToMany(Folder::class)->where('folders.active', true)->withPivot('can_read', 'can_write', 'active');
    }

}
