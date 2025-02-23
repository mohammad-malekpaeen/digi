<?php

namespace Core\Http\Responses\Concerns;

use App\Casts\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @property-read mixed $data
 * @property-read Status $status
 */
trait HasResponse
{
    /**
     * @param  Request  $request
     */
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: $this->data,
            status: $this->status->value,
        );
    }
}
