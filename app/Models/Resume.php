<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    protected $fillable = [
        'original_name',
        'file_path',
        'file_size',
        'is_active',
        'download_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'file_size' => 'integer',
        'download_count' => 'integer',
    ];

    /**
     * Get the active resume file.
     */
    public static function active()
    {
        return static::where('is_active', true)->latest()->first();
    }
}
