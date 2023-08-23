<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logins extends Model
{
    use HasFactory;

    protected $table = 'logins';

    protected $fillable = [
        'user_id',
        'verified',
        'verification_code_issue_date',
        'verification_code_expiration_date',
        'forgot_password',
        'renovation_date',
        'renovation_code_issue_date',
        'renovation_code_expiration_date',
        'last_login_date',
        'active',
        'was_imported',
        'first_login',
    ];

    protected $hidden = [
        'password',
        'verification_code',
        'renovation_code'
    ];

    /**
     * Returns the user to whom the login belongs.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
