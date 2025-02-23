<?php

namespace Core\Http\Responses;

use App\Casts\Status;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ArrayResponse implements Responsable
{
    public function __construct(
        private readonly array $data,
        private readonly Status $status = Status::OK,
    ) {
    }

    /**
     * @param  Request  $request
     */
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: [
                'data' => $this->data,
            ],
            status: $this->status->value,
        );
    }
}
