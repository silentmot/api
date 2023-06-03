<?php

namespace Afaqy\Core\Http\Transformers\Serializer;

use League\Fractal\Pagination\CursorInterface;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Serializer\SerializerAbstract;

/**
 * @codeCoverageIgnore
 */
class ArraySerializer extends SerializerAbstract
{
    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array  $data
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        return ($resourceKey !== false) ? [$resourceKey ?: 'data' => $data] : $data;
    }

    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array  $data
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        return $data;
    }

    /**
     * Serialize null resource.
     *
     * @return array
     */
    public function null()
    {
        return [];
    }

    /**
     * Serialize the included data.
     *
     * @param ResourceInterface $resource
     * @param array             $data
     * @return array
     */
    public function includedData(ResourceInterface $resource, array $data)
    {
        return $data;
    }

    /**
     * Serialize the meta.
     *
     * @param array $meta
     * @return array
     */
    public function meta(array $meta)
    {
        if (empty($meta)) {
            return [];
        }

        return ['meta' => $meta];
    }

    /**
     * Serialize the paginator.
     *
     * @param PaginatorInterface $paginator
     * @return array
     */
    public function paginator(PaginatorInterface $paginator)
    {
        $currentPage = (int) $paginator->getCurrentPage();
        $lastPage    = (int) $paginator->getLastPage();

        $pagination = [
            'current_page'  => $currentPage,
            'first_page'    => 1,
            'last_page'     => $lastPage,
            'per_page'      => (int) $paginator->getPerPage(),
            'count'         => (int) $paginator->getCount(),
            'total_records' => (int) $paginator->getTotal(),
        ];

        $pagination['links']             = [];
        $pagination['links']['first']    = $paginator->getUrl(1);
        $pagination['links']['last']     = $paginator->getUrl($lastPage);
        $pagination['links']['previous'] = null;
        $pagination['links']['next']     = null;

        if ($currentPage > 1) {
            $pagination['links']['previous'] = $paginator->getUrl($currentPage - 1);
        }

        if ($currentPage < $lastPage) {
            $pagination['links']['next'] = $paginator->getUrl($currentPage + 1);
        }

        if (empty($pagination['links'])) {
            $pagination['links'] = (object) [];
        }

        return ['pagination' => $pagination];
    }

    /**
     * Serialize the cursor.
     *
     * @param CursorInterface $cursor
     * @return array
     */
    public function cursor(CursorInterface $cursor)
    {
        $cursor = [
            'current' => $cursor->getCurrent(),
            'prev'    => $cursor->getPrev(),
            'next'    => $cursor->getNext(),
            'count'   => (int) $cursor->getCount(),
        ];

        return ['cursor' => $cursor];
    }
}
