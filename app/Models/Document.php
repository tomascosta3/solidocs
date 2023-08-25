<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';

    protected $fillable = [
        'name',
        'comment',
        'path',
        'created_by',
        'required_access_level'
    ];

    /**
     * This relationship fetches the user who created the document.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
