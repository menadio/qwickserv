<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

class Category extends Model
{
    use HasFactory, SoftDeletes, Actionable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'icon',
        'status_id'
    ];

    /**
     * services in a catehory
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
