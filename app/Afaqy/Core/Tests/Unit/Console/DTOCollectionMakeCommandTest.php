<?php

namespace Afaqy\Core\Tests\Unit\Console;

use Tests\TestCase;
use Nwidart\Modules\Contracts\RepositoryInterface;

class DTOCollectionMakeCommandTest extends TestCase
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
    public function it_generates_a_new_dto_collection_class()
    {
        $this->artisan('module:make-dto-collection', ['collection-dto' => 'MyCollection', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/DTO/Collections/MyCollection.php'));
    }

    /** @test */
    public function it_appends_dto_collection_name_if_not_present()
    {
        $this->artisan('module:make-dto-collection', ['collection-dto' => 'My', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/DTO/Collections/MyCollection.php'));
    }

    /** @test */
    public function it_can_change_the_default_namespace()
    {
        $this->app['config']->set('modules.paths.generator.dto-collection.path', 'Domain/Collections');

        $this->artisan('module:make-dto-collection', ['collection-dto' => 'MyCollection', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/Domain/Collections/MyCollection.php'));
    }

    /** @test */
    public function it_can_generate_a_dto_collection_in_sub_namespace_in_correct_folder()
    {
        $this->artisan('module:make-dto-collection', ['collection-dto' => 'SubDomain\\MyCollection', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/DTO/Collections/SubDomain/MyCollection.php'));
    }
}
