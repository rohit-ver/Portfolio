<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    use HasFactory;

    public $timestamps = false; // Only created_at is stored

    protected $fillable = [
        'visitor_id',
        'session_id',
        'path',
        'page_title',
        'referrer',
        'source',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'device',
        'browser',
        'os',
        'country',
        'city',
        'ip_hash',
        'is_bot',
        'created_at',
    ];

    protected $casts = [
        'is_bot' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function scopeHuman($query)
    {
        return $query->where('is_bot', false);
    }
}
