<?php

namespace Afaqy\Core\Tests\Unit\Http\Reports;

use Tests\TestCase;
use EloquentFilter\Filterable;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use League\Fractal\TransformerAbstract;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Core\Models\Filters\ModelFilter;
use Illuminate\Database\Eloquent\Model as Eloquent;

class GeneratorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->schema()->create('animals', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Animal::insert([
            ['id' => 1, 'name' => 'Lion'],
            ['id' => 2, 'name' => 'cat'],
            ['id' => 3, 'name' => 'dog'],
        ]);
    }

    protected function tearDown(): void
    {
        $this->schema()->drop('animals');
    }

    /** @test */
    public function it_returns_data_in_paginated_format_by_default()
    {
        $report = new DumyGenerator;

        $data = $report->show();

        $data =json_decode($data->content(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('meta', $data);
    }

    /** @test */
    public function it_returns_all_data_when_pass_all_pages_parameter()
    {
        $report = new DumyGenerator;

        $report->request = request()->merge(['all_pages' => 1]);

        $data = $report->show();

        $data =json_decode($data->content(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayNotHasKey('meta', $data);
    }

    /** @test */
    public function it_can_change_per_page_number_by_request()
    {
        $report = new DumyGenerator;

        $report->request = request()->merge(['per_page' => 2]);

        $data = $report->show();

        $data =json_decode($data->content(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('meta', $data);
        $this->assertEquals(2, $data['meta']['pagination']['per_page']);
    }

    /** @test */
    public function it_can_change_per_page_number_by_pass_options_array()
    {
        $report = new DumyGenerator;

        $report->options['per_page'] = 2;

        $data = $report->show();

        $data =json_decode($data->content(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('meta', $data);
        $this->assertEquals(2, $data['meta']['pagination']['per_page']);
    }

    /** @test */
    public function it_can_include_other_transformers()
    {
        $report = new DumyGenerator;

        $report->options['include'] = ['additional'];

        $data = $report->show();

        $data =json_decode($data->content(), true);

        $this->assertArrayHasKey('additional', $data['data'][0]);
    }

    /**
     * Get a database connection instance.
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    protected function connection()
    {
        return Eloquent::getConnectionResolver()->connection();
    }

    /**
     * Get a schema builder instance.
     *
     * @return \Illuminate\Database\Schema\Builder
     */
    protected function schema()
    {
        return $this->connection()->getSchemaBuilder();
    }
}

class DumyGenerator extends Report
{
    use Generator;

    public $request;

    public $options;

    public function query(): Builder
    {
        return Animal::query();
    }

    public function generate()
    {
        return $this->generateViewList(
            $this->query(),
            new DumyGeneratorTransformer,
            $this->request ?? request(),
            $this->options ?? []
        );
    }
}

class DumyGeneratorTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'additional',
    ];

    public function transform($data): array
    {
        return [
            'id'   => $data->id,
            'name' => $data->name,
        ];
    }

    public function includeAdditional($data)
    {
        return $this->primitive('more_data');
    }
}

class Animal extends Eloquent
{
    use Filterable;

    protected $table = 'animals';

    protected $guarded = [];

    protected $hidden = ['updated_at', 'deleted_at'];

    /**
     * @codeCoverageIgnore
     */
    public function modelFilter()
    {
        return $this->provideFilter(AnimalFilter::class);
    }
}

class AnimalFilter extends ModelFilter
{
}
