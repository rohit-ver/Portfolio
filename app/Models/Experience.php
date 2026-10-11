<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'company',
        'designation',
        'location',
        'type',
        'start_date',
        'end_date',
        'is_current',
        'description',
        'responsibilities',
        'tech_stack',
        'sort_order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'responsibilities' => 'array',
        'tech_stack' => 'array',
        'sort_order' => 'integer',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('start_date', 'desc');
    }
}
