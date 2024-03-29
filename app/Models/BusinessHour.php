<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class BusinessHour extends Model
{
    use HasFactory, Actionable;

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

    /**
     * Get business that owns a business hour
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
