<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessBank extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Attributes not mass assignable
     * 
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get bank
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    /**
     * Get business
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
