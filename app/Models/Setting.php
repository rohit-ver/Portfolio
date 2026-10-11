<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group'];

    /**
     * Cache key prefix for individual settings.
     */
    protected const CACHE_PREFIX = 'portfolio_setting_';

    /**
     * Get a setting by key with optional fallback, cached forever.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever(static::CACHE_PREFIX . $key, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set/update a setting value and clear its cache.
     *
     * @param string $key
     * @param mixed $value
     * @param string $group
     * @return self
     */
    public static function set(string $key, $value, string $group = 'general'): self
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );

        // Clear cache for this specific setting key
        Cache::forget(static::CACHE_PREFIX . $key);

        return $setting;
    }

    /**
     * Clear all settings from cache.
     */
    public static function clearAllCache(): void
    {
        $keys = static::pluck('key');
        foreach ($keys as $key) {
            Cache::forget(static::CACHE_PREFIX . $key);
        }
    }
}
