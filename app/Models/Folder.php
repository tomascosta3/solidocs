<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'active',
    ];


    /**
     * Get subfolders.
     */
    public function subfolders() {
        
        return $this->hasMany(Folder::class, 'parent_id');
    }

    /**
     * Get parent folder.
     */
    public function parent() {

        return $this->belongsTo(Folder::class, 'parent_id');
    }


    /**
     * Get children folders.
     */
    public function children() {

        return $this->hasMany(Folder::class, 'parent_id');
    }


    /**
     * Get all folder's documents.
     */
    public function documents() {

        return $this->hasMany(Document::class);
    }


    /**
     * Get folder's groups.
     */
    public function groups() {

        return $this->belongsToMany(Group::class)->where('groups.active', true)->withPivot('can_read', 'can_write', 'active');
    }
}
