<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'title', 'description', 'category', 'icon', 'sub_items', 'sort_order'
    ];

    protected $casts = [
        'sub_items' => 'array',
    ];

    public function details(): HasMany
    {
        return $this->hasMany(ServiceDetail::class, 'service_id');
    }
}
