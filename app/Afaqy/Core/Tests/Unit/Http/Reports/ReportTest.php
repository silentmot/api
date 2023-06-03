<?php

namespace Afaqy\Core\Tests\Unit\Http\Reports;

use Tests\TestCase;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Cachable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

class ReportTest extends TestCase
{
    /** @test */
    public function it_returns_generated_data_when_no_cache_available()
    {
        $report = new DumyReport;

        $this->assertInstanceOf(Builder::class, $report->query());
        $this->assertEquals('output', $report->show());
    }

    /** @test */
    public function it_returns_cached_data_when_cache_available()
    {
        $report = new CacheDumyReport;

        Cache::shouldReceive('getStore')
            ->once()
            ->andReturn(null)
            ->shouldReceive('remember')
            ->once()
            ->andReturn($report->generate());

        $this->assertInstanceOf(Builder::class, $report->query());
        $this->assertEquals('output', $report->show());
    }
}

class DumyReport extends Report
{
    public function query(): Builder
    {
        return resolve(Builder::class);
    }

    public function generate()
    {
        return 'output';
    }
};

class CacheDumyReport extends Report
{
    use Cachable;

    public function query(): Builder
    {
        return resolve(Builder::class);
    }

    public function generate()
    {
        return 'output';
    }
};
