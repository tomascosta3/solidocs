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
        'sector_id',
        'created_by'
    ];

    /**
     * This relationship fetches the sector of the document.
     */
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    /**
     * This relationship fetches the user who created the document.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
