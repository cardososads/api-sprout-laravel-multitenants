<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

final class PaginateCollectionResponse implements Responsable
{
    public function __construct(
        private readonly AnonymousResourceCollection $data,
        private readonly int $status = Response::HTTP_OK
    )
    {}
    public function toResponse($request): Response
    {
        return new JsonResponse(
            data: $this->data,
            status: $this->status,


        );
    }
}
