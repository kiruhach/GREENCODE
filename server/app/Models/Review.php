<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'name', 'role', 'text', 'initials', 'status'
    ];

    protected $casts = [
        'status' => 'string',
    ];
}
