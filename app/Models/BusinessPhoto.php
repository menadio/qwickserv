<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessPhoto extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Attribute not mass assignable
     * 
     * @var array
     */
    protected $guarded = ['id'];
}
