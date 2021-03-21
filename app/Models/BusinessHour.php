<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessHour extends Model
{
    use HasFactory;

    /**
     * Attributes not mass assignable
     * 
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Cast to type
     * 
     * @var array
     */
    protected $casts = [
        'opens_at'  => 'string',
        'closes_at' => 'string'
    ];
    

    /**
     * Get business day of the week it belongs to
     */
    public function weekDay()
    {
        return $this->belongsTo(WeekDay::class);
    }
}
