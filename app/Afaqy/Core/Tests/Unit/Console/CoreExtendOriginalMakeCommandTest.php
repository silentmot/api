<?php

namespace Afaqy\Core\Tests\Unit\Console;

use Tests\TestCase;
use Nwidart\Modules\Contracts\RepositoryInterface;

class CoreExtendOriginalMakeCommandTest extends TestCase
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
    public function it_generates_a_new_action_class()
    {
        $this->assertTrue(is_file($this->modulePath . '/Actions/BlogAction.php'));
    }

    /** @test */
    public function it_generates_a_new_report_class()
    {
        $this->assertTrue(is_file($this->modulePath . '/Http/Reports/BlogListReport.php'));
    }

    /** @test */
    public function it_generates_a_new_transformer_class()
    {
        $this->assertTrue(is_file($this->modulePath . '/Http/Transformers/BlogTransformer.php'));
    }

    /** @test */
    public function it_generates_a_new_DTO_class()
    {
        $this->assertTrue(is_file($this->modulePath . '/DTO/BlogData.php'));
    }

    /** @test */
    public function it_generates_a_new_model_class()
    {
        $this->assertTrue(is_file($this->modulePath . '/Models/Blog.php'));
    }

    /** @test */
    public function it_generates_a_new_model_filter_class()
    {
        $this->assertTrue(is_file($this->modulePath . '/Models/Filters/BlogFilter.php'));
    }
}
