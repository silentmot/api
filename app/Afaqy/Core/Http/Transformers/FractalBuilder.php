<?php

namespace Afaqy\Core\Http\Transformers;

use Spatie\Fractal\Facades\Fractal;
use League\Fractal\TransformerAbstract;
use Spatie\Fractalistic\Fractal as BaseFractal;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Afaqy\Core\Http\Transformers\Serializer\ArraySerializer;

trait FractalBuilder
{
    /**
     * Transform fractal collection.
     *
     * @param  mixed               $collection
     * @param  TransformerAbstract $transformer
     * @param  array               $includes
     * @return array
     */
    public function fractalCollection($collection, TransformerAbstract $transformer, array $includes = []): array
    {
        return $this->fractalCollectionBuilder($collection, $transformer, $includes)->toArray();
    }

    /**
     * Transform fractal collection paginated.
     *
     * @param  mixed               $collection
     * @param  TransformerAbstract $transformer
     * @param  array               $includes
     * @return array
     */
    public function fractalCollectionPaginated($collection, TransformerAbstract $transformer, array $includes = []): array
    {
        return $this->fractalCollectionBuilder($collection, $transformer, $includes)
            ->paginateWith(new IlluminatePaginatorAdapter($collection))
            ->toArray();
    }

    /**
     * Transform fractal item.
     *
     * @param  mixed               $collection
     * @param  TransformerAbstract $transformer
     * @param  array               $includes
     * @return array
     */
    public function fractalItem($collection, TransformerAbstract $transformer, array $includes = []): array
    {
        return Fractal::create()
            ->item($collection, $transformer)
            ->serializeWith(new ArraySerializer())
            ->parseIncludes($includes)
            ->toArray();
    }

    /**
     * Create base fractal collection instance.
     *
     * @param  mixed               $collection
     * @param  TransformerAbstract $transformer
     * @param  array               $includes
     * @return \Spatie\Fractalistic\Fractal
     */
    private function fractalCollectionBuilder($collection, TransformerAbstract $transformer, array $includes = []): BaseFractal
    {
        return Fractal::create()
            ->collection($collection, $transformer)
            ->serializeWith(new ArraySerializer())
            ->parseIncludes($includes);
    }
}
