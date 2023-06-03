<?php

namespace Afaqy\Core\Http\Reports;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use League\Fractal\TransformerAbstract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait Generator
{
    /**
     * Generate view list from the given query
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \League\Fractal\TransformerAbstract    $transformer
     * @param  \Illuminate\Http\Request               $request
     * @param  array                                  $options
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateViewList(
        Builder $query,
        TransformerAbstract $transformer,
        Request $request,
        array $options = []
    ): JsonResponse {
        $query->filter($request->all(), $options['filter'] ?? null);

        if ($request->has('all_pages')) {
            $result = $query->get();

            $data = $this->fractalCollection($result, $transformer, $options['include'] ?? []);

            return $this->returnSuccess('', $data);
        }

        $result = $query->paginateFilter($request->query('per_page') ?? $options['per_page'] ?? 50);

        $data = $this->fractalCollectionPaginated($result, $transformer, $options['include'] ?? []);

        return $this->returnSuccess('', $data);
    }

    /**
     * Generate items for select list from the given query
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \League\Fractal\TransformerAbstract    $transformer
     * @param  array                                  $includes
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateSelectList(
        Builder $query,
        TransformerAbstract $transformer,
        array $includes = []
    ): JsonResponse {
        $result = $query->get();

        $data = $this->fractalCollection($result, $transformer, $includes);

        return $this->returnSuccess('', $data);
    }

    /**
     * Generate view show item from the given query
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \League\Fractal\TransformerAbstract    $transformer
     * @param  array                                  $includes
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateViewShow(
        Builder $query,
        TransformerAbstract $transformer,
        array $includes = []
    ): JsonResponse {
        $result = $query->firstOrFail();

        $data = $this->fractalItem($result, $transformer, $includes);

        return $this->returnSuccess('', $data);
    }

    /**
     * Generate view show item from the given query
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \League\Fractal\TransformerAbstract    $transformer
     * @param  array                                  $includes
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateJoinViewShow(
        Builder $query,
        TransformerAbstract $transformer,
        array $includes = [],
        bool $emptyNotAllowed = true
    ): JsonResponse {
        $result = $query->get();

        if ($result->isEmpty() && $emptyNotAllowed) {
            throw new ModelNotFoundException;
        }

        $data = $this->fractalItem($result, $transformer, $includes);

        return $this->returnSuccess('', $data);
    }
}
