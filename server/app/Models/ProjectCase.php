<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCase extends Model
{
    protected $table = 'cases';

    protected $fillable = [
        'title', 'description', 'image', 'tags', 'category',
        'full_description', 'result', 'task', 'solution', 'results'
    ];

    protected $casts = [
        'tags' => 'array',
        'results' => 'array',
    ];
}
