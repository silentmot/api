<?php

namespace Afaqy\Core\Tests\Unit\Console;

use Tests\TestCase;
use Nwidart\Modules\Contracts\RepositoryInterface;

class TransformerMakeCommandTest extends TestCase
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
    public function it_generates_a_new_transformer_class()
    {
        $this->artisan('module:make-transformer', ['transformer' => 'MyTransformer', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/Http/Transformers/MyTransformer.php'));
    }

    /** @test */
    public function it_appends_transformer_name_if_not_present()
    {
        $this->artisan('module:make-transformer', ['transformer' => 'My', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/Http/Transformers/MyTransformer.php'));
    }

    /** @test */
    public function it_can_change_the_default_namespace()
    {
        $this->app['config']->set('modules.paths.generator.transformer.path', 'Domain/Transformers');

        $this->artisan('module:make-transformer', ['transformer' => 'MyTransformer', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/Domain/Transformers/MyTransformer.php'));
    }

    /** @test */
    public function it_can_generate_a_transformer_in_sub_namespace_in_correct_folder()
    {
        $this->artisan('module:make-transformer', ['transformer' => 'SubDomain\\MyTransformer', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/Http/Transformers/SubDomain/MyTransformer.php'));
    }
}
