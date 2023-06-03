<?php

namespace Afaqy\Core\Http\Reports;

use Illuminate\Cache\TaggableStore;
use Illuminate\Support\Facades\Cache;

trait Cachable
{
    /**
     * @var string
     */
    public $cache_key;

    /**
     * Cache time by seconds
     *
     * @var int
     */
    public $cache_time = 3600;

    /**
     * cache tag key
     *
     * @var string
     */
    public $cache_tag;

    /**
     * Get cached data
     *
     * @return mixed
     */
    public function getCache()
    {
        $this->cache_key = $this->cache_key ?? $this->generateKey();

        if (Cache::getStore() instanceof TaggableStore) {
            $this->cache_tag = $this->cache_tag ?? $this->generateCacheTag();

            return Cache::tags(['REPORTS', $this->cache_tag])->remember($this->cache_key, $this->cache_time, function () {
                return $this->generate();
            });
        }

        return Cache::remember($this->cache_key, $this->cache_time, function () {
            return $this->generate();
        });
    }

    /**
     * Generate cache key from class name
     *
     * @return string
     */
    public function generateKey(): string
    {
        $class = new \ReflectionClass($this);

        return $class->getShortName();
    }

    /**
     * Generate cache tag from module name
     *
     * @return string
     */
    public function generateCacheTag(): string
    {
        $class = new \ReflectionClass($this);

        $class = explode('\\', $class->getNamespaceName());

        return strtoupper($class[1]) . '_REPORTS';
    }

    /**
     * Rebuild cached data
     *
     * @return mixed
     */
    public function cacheRebuild()
    {
        $key = $this->cache_key ?? $this->generateKey();

        Cache::forget($key);

        return $this->getCache();
    }
}
