<?php

namespace Core\Http\Resources;

final class CustomPaginatedResourceResponse extends BasePaginatedResourceResponse
{
    /**
     * Gather the meta data for the response.
     *
     * @param  array  $paginated
     */
    protected function meta($paginated): array
    {
        return [
            'current_page' => $paginated['current_page'],
            'from' => $paginated['from'],
            'last_page' => $paginated['last_page'],
            'per_page' => $paginated['per_page'],
            'to' => $paginated['to'],
            'total' => $paginated['total'],
        ];
    }
}
