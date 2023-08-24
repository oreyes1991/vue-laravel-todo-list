<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'completed_at', 'user_id'
    ];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */

    protected $casts = [
        'completed_at' => 'datetime'
    ];
}
