<?php

namespace App\Http\Controllers\API;

use App\Contracts\Mediator\DtoMediatorContract;
use App\Contracts\Services\PostServiceContract;
use App\Dto\PostDto;
use App\Enum\FieldEnum;
use App\Enum\PostStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\PostStoreRequest;
use App\Http\Requests\API\PostUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{

    public function __construct(
        protected DtoMediatorContract $dtoMediator,
        protected PostServiceContract $postService
    )
    {
    }

    public function search(Request $request): JsonResponse
    {
        $posts = $this->postService->search($request->input(FieldEnum::keyword->value));

        return response()->json([
            FieldEnum::response->value => $posts,
        ]);
    }

    /**
     * @param PostStoreRequest $request
     *
     */
    public function store(PostStoreRequest $request)
    {
        $dto = $this->getDtoFromRequest($request);
        $this->postService->create($dto);

        return response(null, Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return PostDto
     */
    public function getDtoFromRequest(Request $request): PostDto
    {
        return $this->dtoMediator->convertDataToPostDto(
            title: $request->input(FieldEnum::title->name),
            slug: $request->input(FieldEnum::slug->name),
            status: PostStatus::tryFromName($request->input(FieldEnum::status->name)),
            imageId: $request->input(FieldEnum::imageId->name),
            body: $request->input(FieldEnum::body->name),
            excerpt: $request->input(FieldEnum::excerpt->name),
            publishedAt: $request->input(FieldEnum::publishedAt->name),
            hasComment: $request->input(FieldEnum::hasComment->name, true),
            categories: $request->input(FieldEnum::categories->name, []),
            categoryId: $request->input(FieldEnum::categoryId->name),
        );
    }

    /**
     * @param PostUpdateRequest $request
     * @param int $id
     */
    public function update(PostUpdateRequest $request, int $id)
    {
        $dto = $this->getDtoFromRequest($request)->setId($id);
        $this->postService->update($dto);

        return response(null, Response::HTTP_OK);
    }


}
