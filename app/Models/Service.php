<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * Attributes not mass assignable
     * 
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get service category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get service status
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

}
