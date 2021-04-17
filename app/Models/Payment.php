<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

class Payment extends Model
{
    use HasFactory, SoftDeletes, Actionable;

    /**
     * Attributes not mass assignable
     */
    protected $guarded = ['id'];

    /**
     * Get payment user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get business payment was made to
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Get booking paymment was made for
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get status of a payment
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
