<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'logo',
        'category_id',
        'status_id',
        'services'
    ];

    protected $casts = ['services' => 'array'];

    /**
     * Business owner
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get business category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Business hours
     */
    public function businessHours()
    {
        return $this->hasMany(BusinessHour::class);
    }

    /**
     * Get business photos
     */
    public function photos()
    {
        return $this->hasMany(BusinessPhoto::class);
    }

    /**
     * Get business bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class)->orderByDesc('id');
    }

    /**
     * Get business reviews
     */
    public function reviews()
    {
        return $this->hasMany(Review::class)->orderByDesc('id');
    }

    /**
     * Get business status
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
