<?php

namespace Afaqy\Core\Tests\Unit\Console;

use Tests\TestCase;
use Nwidart\Modules\Contracts\RepositoryInterface;

class DTOMakeCommandTest extends TestCase
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
    public function it_generates_a_new_dto_class()
    {
        $this->artisan('module:make-dto', ['dto' => 'MyData', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/DTO/MyData.php'));
    }

    /** @test */
    public function it_appends_dto_name_if_not_present()
    {
        $this->artisan('module:make-dto', ['dto' => 'My', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/DTO/MyData.php'));
    }

    /** @test */
    public function it_can_change_the_default_namespace()
    {
        $this->app['config']->set('modules.paths.generator.dto.path', 'Domain/DTO');

        $this->artisan('module:make-dto', ['dto' => 'MyData', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/Domain/DTO/MyData.php'));
    }

    /** @test */
    public function it_can_generate_a_dto_in_sub_namespace_in_correct_folder()
    {
        $this->artisan('module:make-dto', ['dto' => 'SubDomain\\MyData', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/DTO/SubDomain/MyData.php'));
    }
}
