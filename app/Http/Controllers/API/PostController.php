<?php

namespace App\Http\Controllers\API;

use App\Contracts\Mediator\DtoMediatorContract;
use App\Contracts\Services\PostSearchServiceContract;
use App\Contracts\Services\PostServiceContract;
use App\Dto\PostDto;
use App\Enum\FieldEnum;
use App\Facades\StringFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\PostRequest;
use App\Http\Resources\API\PostResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct(
        protected DtoMediatorContract $dtoMediator,
        protected PostServiceContract $postService,
        protected PostSearchServiceContract $searchService,
    )
    {
    }

    /**
     * @param PostRequest $request
     *
     */
    public function store(PostRequest $request)
    {
        $dto = $this->getDtoFromRequest($request);
        $post = $this->postService->create($dto);

        return PostResource::make([
            'message' => trans('message.post-store-success'),
            'posts' => $post,
        ]);
    }

    /**
     * @param PostRequest $request
     * @return PostDto
     */
    public function getDtoFromRequest(PostRequest $request): PostDto
    {
        return $this->dtoMediator->convertDataToPostDto(
            category_id: $request->getInputCategoryId(),
            user_id: $request->getInputUserId(),
            title: $request->getInputTitle(),
            slug: StringFacade::slug($request->getInputSlug()),
            body: $request->getInputBody(),
        );
    }

    /**
     * @param PostRequest $request
     * @param int $id
     */
    public function update(PostRequest $request, int $id)
    {
        $dto = $this->getDtoFromRequest($request)->setId($id);
        $this->postService->update($dto);

        return response()->json([
            'message' => trans('message.post-update-success'),
        ]);
    }


    public function search(Request $request): JsonResponse
    {
        $query = $request->input(FieldEnum::query->value);
        $categoryId = $request->input(FieldEnum::categoryId->value);
        $userId = $request->input(FieldEnum::userId->value);

        $results = $this->searchService
                        ->search()
                        ->filterByCategory($categoryId)
                        ->filterByAuthor($userId)
                        ->paginate($request->input('per_page', 15))
                        ->execute();

        return response()->json([
            'data' => $results->items(),
            'meta' => [
                'current_page' => $results->currentPage(),
                'total_pages' => $results->lastPage(),
                'total_items' => $results->total(),
            ]
        ]);
    }

}
