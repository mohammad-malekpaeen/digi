<?php

namespace Core\Http\Responses;

use App\Casts\Status;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class CollectionResponse implements Responsable
{
    public function __construct(
        private readonly AnonymousResourceCollection $data,
        private readonly Status $status = Status::OK,
    ) {
    }

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
