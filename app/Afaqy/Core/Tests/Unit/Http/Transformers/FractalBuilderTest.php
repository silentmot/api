<?php

namespace Afaqy\Core\Tests\Unit\Http\Transformers;

use Tests\TestCase;
use League\Fractal\TransformerAbstract;
use Afaqy\Core\Http\Transformers\FractalBuilder;
use Illuminate\Database\Eloquent\Model as Eloquent;

class FractalBuilderTest extends TestCase
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
        ]);
    }

    protected function tearDown(): void
    {
        $this->schema()->drop('animals');
    }

    /** @test */
    public function it_transforms_collections()
    {
        $data = Animal::all();

        $expected_data = [
            'data' => [
                [
                    'animal_id'   => 1,
                    'animal_name' => 'Lion',
                ],
                [
                    'animal_id'   => 2,
                    'animal_name' => 'cat',
                ],
            ],
        ];

        $fractal = new FractalBuilderDummy;

        $formated_data = $fractal->fractalCollection($data, new FractalBuilderTransformer);

        $this->assertEquals($expected_data, $formated_data);
    }

    /** @test */
    public function it_transforms_paginated_collections()
    {
        $data = Animal::paginate(15);

        $expected_data = [
            'data' => [
                [
                    'animal_id'   => 1,
                    'animal_name' => 'Lion',
                ],
                [
                    'animal_id'   => 2,
                    'animal_name' => 'cat',
                ],
            ],
            'meta' => [
                "pagination" => [
                    "current_page"  => 1,
                    "first_page"    => 1,
                    "last_page"     => 1,
                    "per_page"      => 15,
                    "count"         => 2,
                    "total_records" => 2,
                    "links"         => [
                        "first"    => env("APP_URL") . "?page=1",
                        "last"     => env("APP_URL") . "?page=1",
                        "previous" => null,
                        "next"     => null,
                    ],
                ],
            ],
        ];

        $fractal = new FractalBuilderDummy;

        $formated_data = $fractal->fractalCollectionPaginated($data, new FractalBuilderTransformer);

        $this->assertEquals($expected_data, $formated_data);
    }

    /** @test */
    public function it_transforms_items()
    {
        $data = Animal::find(1);

        $expected_data = [
            'animal_id'   => 1,
            'animal_name' => 'Lion',
        ];

        $fractal = new FractalBuilderDummy;

        $formated_data = $fractal->fractalItem($data, new FractalBuilderTransformer);

        $this->assertEquals($expected_data, $formated_data);
    }

    /** @test */
    public function it_can_include_addtional_transfomers_with_main_data()
    {
        $data = Animal::find(1);

        $expected_data = [
            'animal_id'   => 1,
            'animal_name' => 'Lion',
            'additional'  => 'more_data',
        ];

        $fractal = new FractalBuilderDummy;

        $formated_data = $fractal->fractalItem($data, new FractalBuilderTransformer, ['additional']);

        $this->assertEquals($expected_data, $formated_data);
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

class FractalBuilderDummy
{
    use FractalBuilder;
}

class FractalBuilderTransformer extends TransformerAbstract
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
            'animal_id'   => $data->id,
            'animal_name' => $data->name,
        ];
    }

    public function includeAdditional($data)
    {
        return $this->primitive('more_data');
    }
}

class Animal extends Eloquent
{
    protected $table = 'animals';

    protected $guarded = [];

    protected $hidden = ['updated_at', 'deleted_at'];
}
