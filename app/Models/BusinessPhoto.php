<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

class BusinessPhoto extends Model
{
    use HasFactory, SoftDeletes, Actionable;

    /**
     * Attribute not mass assignable
     * 
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get photo business
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
