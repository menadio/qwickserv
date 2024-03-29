<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Nova\Actions\Actionable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Actionable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'otp',
        'gender',
        'profile_image',
        'account_type_id',
        'status_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * User has an account type
     */
    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }

    /**
     * Status of an account
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * User has a business
     */
    public function business()
    {
        return $this->hasOne(Business::class)->with('businessHours');
    }

    /**
     * Get user bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get reserved booking reservations collections
     */
    public function reservedBookings()
    {
        return $this->hasMany(Booking::class)->where('status_id', 5)
            ->orderByDesc('id');
    }

    /**
     * Get active business bookings collection
     */
    public function activeBookings()
    {
        return $this->hasMany(Booking::class)->where('status_id', 8)
            ->orderByDesc('id');
    }

    /**
     * Get completed business bookings collection
     */
    public function completedBookings()
    {
        return $this->hasMany(Booking::class)->where('status_id', 6)
            ->orderByDesc('id');
    }
}
