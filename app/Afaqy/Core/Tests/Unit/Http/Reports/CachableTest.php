<?php

namespace Afaqy\Core\Tests\Unit\Http\Reports;

use Tests\TestCase;
use Illuminate\Cache\CacheManager;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Cachable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

class CachableTest extends TestCase
{
    /** @test */
    public function it_caches_data_without_domain_tags_if_store_cache_not_taggable()
    {
        $cacheManager = resolve(CacheManager::class);

        $fileStore = $cacheManager->driver('file');

        $report = new DumyCachable;

        Cache::swap($fileStore);

        $this->assertEquals($report->generate(), $report->show());
        $this->assertEmpty($report->cache_tag);

        Cache::flush();
    }

    /** @test */
    public function it_caches_data_with_domain_tags_if_store_cache_taggable()
    {
        $report = new DumyCachable; // cache driver is [array]

        $this->assertEquals($report->generate(), $report->show());
    }

    /** @test */
    public function it_generates_cache_key_when_no_cache_key_provided()
    {
        $report = new DumyCachable;

        $this->assertEmpty($report->cache_key);

        $report->show();

        $this->assertEquals($report->cache_key, 'DumyCachable');
    }

    /** @test */
    public function it_sets_cache_time_when_no_cache_time_provided()
    {
        $report = new DumyCachable;

        $report->show();

        $this->assertEquals($report->cache_time, 3600);
    }

    /** @test */
    public function it_generates_cache_tag_when_no_cache_key_provided()
    {
        $report = new DumyCachable;

        $this->assertEmpty($report->cache_tag);

        $report->show();

        $this->assertEquals($report->cache_tag, 'CORE_REPORTS');
    }

    /** @test */
    public function it_caches_data_with_specified_cache_key()
    {
        $report = new DumyCachable;

        $report->cache_key = 'TestCacheKey';

        $report->show();

        $this->assertEquals($report->cache_key, 'TestCacheKey');
    }

    /** @test */
    public function it_caches_data_with_specified_cache_time()
    {
        $report = new DumyCachable;

        $report->cache_time = 86400; // day

        $report->show();

        $this->assertEquals($report->cache_time, 86400);
    }

    /** @test */
    public function it_caches_data_with_specified_cache_tag()
    {
        $report = new DumyCachable;

        $report->cache_tag = 'DummyCacheTag';

        $report->show();

        $this->assertEquals($report->cache_tag, 'DummyCacheTag');
    }

    /** @test */
    public function it_rebuild_cache()
    {
        $report = new DumyCachable;

        $this->assertEquals($report->generate(), $report->cacheRebuild());
    }
}

class DumyCachable extends Report
{
    use Cachable;

    /**
     * @codeCoverageIgnore
     */
    public function query(): Builder
    {
        return resolve(Builder::class);
    }

    public function generate()
    {
        return 'output';
    }
};
