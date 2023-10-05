<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['request_id'];


    /**
     * Get all users from a conversation.
     */
    public function users() {

        return $this->belongsToMany(User::class, 'conversation_user');
    }


    /**
     * Get all messages from conversation.
     */
    public function messages() {

        return $this->hasMany(Message::class);
    }


    /**
     * Get conversation requests.
     */
    public function request() {
        
        return $this->belongsTo(Request::class);
    }
}
