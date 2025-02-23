<?php

namespace Core\Http\Resources;

use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Illuminate\Support\Arr;

abstract class BasePaginatedResourceResponse extends PaginatedResourceResponse
{
    /**
     * Add the pagination information to the response.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    protected function paginationInformation($request): array // phpcs:ignore
    {
        $paginated = $this->resource->resource->toArray();

        return [
            'meta' => $this->meta($paginated),
        ];
    }

    public function toResponse($request)
    {
        return tap(response()->json(
            $this->wrap(
                $this->resource->resolve($request),
                array_merge_recursive(
                    $this->paginationInformation($request),
                    $this->resource->with($request),
                    $this->resource->additional
                )
            ),
            $this->calculateStatus()
        ), function ($response) use ($request) {
            $response->original = $this->resource->resource->map(function ($item) {
                if (is_array($item)) {
                    return Arr::get($item, 'resource');
                } else {
                    return $item instanceof \stdClass ? $item : $item->resource;
                }
            });

            $this->resource->withResponse($request, $response);
        });
    }
}
