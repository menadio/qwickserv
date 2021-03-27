<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Attributes not mass assignable
     * 
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get review user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get reviews business
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
