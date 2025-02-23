<?php

namespace Core\Http\Resources;

final class CursorPaginatedResourceResponse extends BasePaginatedResourceResponse
{
    /**
     * Gather the meta data for the response.
     *
     * @param  array  $paginated
     */
    protected function meta($paginated): array
    {
        $parsedNextUrl = parse_url($paginated['next_page_url']);
        $parsedPrevUrl = parse_url($paginated['prev_page_url']);

        $nextCursor = array_key_exists('query', $parsedNextUrl)
            ? explode('=', $parsedNextUrl['query'])[1]
            : null;
        $prevCursor = array_key_exists('query', $parsedPrevUrl)
            ? explode('=', $parsedPrevUrl['query'])[1]
            : null;

        return [
            'per_page' => (int) $paginated['per_page'],
            'next_cursor' => $nextCursor,
            'prev_cursor' => $prevCursor,
            'has_next_page' => (bool) $nextCursor,
        ];
    }
}
