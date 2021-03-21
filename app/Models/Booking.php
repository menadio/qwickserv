<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Attributes not masss assignable
     * 
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get booking owner
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get business of booking
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Get booking status
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
