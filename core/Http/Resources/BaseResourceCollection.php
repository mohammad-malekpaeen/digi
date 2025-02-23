<?php

namespace Core\Http\Resources;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

abstract class BaseResourceCollection extends ResourceCollection
{
    /**
     * @param  \Illuminate\Http\Request  $request
     */
    public function toResponse($request): JsonResponse
    {
        if ($this->resource instanceof CursorPaginator) {
            return (new CursorPaginatedResourceResponse($this))->toResponse($request);
        }

        if ($this->resource instanceof AbstractPaginator) {
            return (new CustomPaginatedResourceResponse($this))->toResponse($request);
        }

        return parent::toResponse($request);
    }
}
