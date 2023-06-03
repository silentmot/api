<?php

namespace Afaqy\Core\Tests\Unit\Console;

use Tests\TestCase;
use Nwidart\Modules\Contracts\RepositoryInterface;

class FilterMakeCommandTest extends TestCase
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
    public function it_generates_a_new_model_filter_class()
    {
        $this->artisan('module:make-model-filter', ['model-filter' => 'MyFilter', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/Models/Filters/MyFilter.php'));
    }

    /** @test */
    public function it_appends_model_filter_name_if_not_present()
    {
        $this->artisan('module:make-model-filter', ['model-filter' => 'My', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/Models/Filters/MyFilter.php'));
    }

    /** @test */
    public function it_can_change_the_default_namespace()
    {
        $this->app['config']->set('modules.paths.generator.model-filter.path', 'Domain/Filters');

        $this->artisan('module:make-model-filter', ['model-filter' => 'MyFilter', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/Domain/Filters/MyFilter.php'));
    }

    /** @test */
    public function it_can_generate_a_model_filter_in_sub_namespace_in_correct_folder()
    {
        $this->artisan('module:make-model-filter', ['model-filter' => 'SubDomain\\MyFilter', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/Models/Filters/SubDomain/MyFilter.php'));
    }
}
