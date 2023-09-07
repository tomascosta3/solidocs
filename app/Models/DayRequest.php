<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayRequest extends Model
{
    use HasFactory;

    protected $table = 'day_requests';

    protected $fillable = [
        'requested_by',
        'day_id',
        'requested_days',
        'start_date',
        'end_date',
        'status',
        'updated_by',
        'active'
    ];


    /**
     * Returns attached day.
     */
    public function day() {

        return $this->belongsTo(Day::class, 'day_id');
    }


    /**
     * Returns user that made the request.
     */
    public function requester() {
        return $this->belongsTo(User::class, 'requested_by');
    }

    /**
     * Return start date formatted like dd/mm/yyyy
     */
    public function formatted_start_date() {

        $date = new DateTime($this->start_date);
        return $date->format('d/m/Y');
    }


    /**
     * Return end date formatted like dd/mm/yyyy
     */
    public function formatted_end_date() {
        
        $date = new DateTime($this->end_date);
        return $date->format('d/m/Y');
    }


    /**
     * Return start date formatted like dd/mm/yyyy hh:mm
     */
    public function formatted_start_date_complete() {

        $date = new DateTime($this->start_date);
        return $date->format('d/m/Y H:i\h\s');
    }


    /**
     * Return end date formatted like dd/mm/yyyy hh:mm
     */
    public function formatted_end_date_complete() {

        $date = new DateTime($this->end_date);
        return $date->format('d/m/Y H:i\h\s');
    }
}
