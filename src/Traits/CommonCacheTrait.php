<?php

namespace LaravelReady\PackageStarter\Traits;

use Illuminate\Support\Facades\Config;

trait CommonCacheTrait
{
    protected $section = 'common';

    /**
     * Get the cache key for the given key
     *
     * @param  string  $key
     * @return string
     */
    protected function getCacheKey($key): string
    {
        return "package-name.{$this->section}.{$key}";
    }
}
