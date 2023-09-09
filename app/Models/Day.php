<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $table = 'days';

    protected $fillable = [
        'type',
        'default_amount',
        'reset_date',
        'need_file',
        'document_id',
        'active',
    ];


    /**
     * Get attached document, else returns null.
     */
    public function document() {

        if($this->need_file && $this->document_id !== null) {

            return $this->belongsTo(Document::class, 'document_id');
        }

        return null;
    }
}
