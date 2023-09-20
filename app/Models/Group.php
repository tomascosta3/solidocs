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
        'active',
    ];


    /**
     * Gets the users who belong to the group.
     */
    public function users() {

        return $this->belongsToMany(User::class)->where('users.active', true);
    }


    /**
     * Gets user's count.
     */
    public function users_count() {

        return $this->belongsToMany(User::class)->where('users.active', true)->count();
    }
}
