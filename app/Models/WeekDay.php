<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class WeekDay extends Model
{
    use HasFactory, Actionable;

    /**
     * Attributes not mass assignable
     * 
     * @var array
     */
    protected $guarded = ['id'];
}
