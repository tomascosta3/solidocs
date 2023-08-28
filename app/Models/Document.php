<?php

namespace App\Models;

use DateTime;
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
        'required_access_level',
        'active'
    ];

    /**
     * This relationship fetches the user who created the document.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    /**
     * Get formatted updated_at date.
     */
    public function formatted_update_date() {

        $date = DateTime::createFromFormat('Y-m-d H:i:s', $this->updated_at);
        $formatted_date = $date->format('d/m/Y H:i:s');

        return $formatted_date;
    }
}
