<?php

namespace Afaqy\Core\Tests\Unit\Console;

use Tests\TestCase;
use Nwidart\Modules\Contracts\RepositoryInterface;

class AggregatorMakeCommandTest extends TestCase
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $finder;

    /**
     * @var string
     */
    private $modulePath;

    public function setUp(): void
    {
        parent::setUp();
        $this->modulePath = base_path('app/Afaqy/Blog');
        $this->finder     = $this->app['files'];
        $this->artisan('module:make', ['name' => ['Blog']]);
    }

    public function tearDown(): void
    {
        $this->app[RepositoryInterface::class]->delete('Blog');
        parent::tearDown();
    }

    /** @test */
    public function it_generates_a_new_aggregator_class()
    {
        $this->artisan('module:make-aggregator', ['aggregator' => 'MyAggregator', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/Actions/Aggregators/MyAggregator.php'));
    }

    /** @test */
    public function it_appends_aggregator_name_if_not_present()
    {
        $this->artisan('module:make-aggregator', ['aggregator' => 'My', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/Actions/Aggregators/MyAggregator.php'));
    }

    /** @test */
    public function it_can_change_the_default_namespace()
    {
        $this->app['config']->set('modules.paths.generator.aggregator.path', 'Domain/Aggregators');

        $this->artisan('module:make-aggregator', ['aggregator' => 'MyAggregator', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/Domain/Aggregators/MyAggregator.php'));
    }

    /** @test */
    public function it_can_generate_a_aggregator_in_sub_namespace_in_correct_folder()
    {
        $this->artisan('module:make-aggregator', ['aggregator' => 'SubDomain\\MyAggregator', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/Actions/Aggregators/SubDomain/MyAggregator.php'));
    }
}
