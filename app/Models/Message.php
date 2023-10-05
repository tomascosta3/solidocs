<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'user_id',
        'message'
    ];


    /**
     * Get user who send the message.
     */
    public function user() {
        
        return $this->belongsTo(User::class);
    }


    /**
     * Get conversation.
     */
    public function conversation() {

        return $this->belongsTo(Conversation::class);
    }
}
