<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClickEvent extends Model
{
    use HasFactory;

    public $timestamps = false; // Only created_at is stored

    protected $fillable = [
        'visitor_id',
        'event',
        'label',
        'path',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
