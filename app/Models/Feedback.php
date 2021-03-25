<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    /** 
     * Attributes mass assignable
     * 
     * @var array
     */
    protected $fillable = ['user_id', 'subject', 'comment'];

    /**
     * Get feedback user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
