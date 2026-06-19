<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'company', 'message',
        'task_details', 'timeframe', 'budget', 'contact_format',
        'services', 'status'
    ];

    protected $casts = [
        'services' => 'array',
    ];
}
