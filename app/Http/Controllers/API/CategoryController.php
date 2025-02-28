<?php

namespace App\Http\Controllers\API;

use App\Contracts\Mediator\DtoMediatorContract;
use App\Contracts\Services\CategoryServiceContract;
use App\Dto\CategoryDto;
use App\Facades\StringFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CategoryRequest;
use App\Http\Resources\API\CategoryResource;

class CategoryController extends Controller
{

    /**
     * @param DtoMediatorContract $dtoMediator
     * @param CategoryServiceContract $categoryService
     */
    public function __construct(
        protected DtoMediatorContract     $dtoMediator,
        protected CategoryServiceContract $categoryService,
    )
    {
    }


    /**
     * @param CategoryRequest $request
     * @return CategoryResource
     */
    public function store(CategoryRequest $request): CategoryResource
    {
        $dto = $this->getDtoFromRequest($request);
        $category = $this->categoryService->create($dto);

        return CategoryResource::make([
            'message' => trans('message.category-store-success'),
            'categories' => $category,
        ]);
    }

    /**
     * @param CategoryRequest $request
     * @return CategoryDto
     */
    public function getDtoFromRequest(CategoryRequest $request): CategoryDto
    {
        return $this->dtoMediator->convertDataToCategoryDto(
            title: $request->getInputTitle(),
            slug: StringFacade::slug($request->getInputSlug()),
        );
    }

    /**
     * @param CategoryRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(CategoryRequest $request, int $id)
    {
        $dto = $this->getDtoFromRequest($request)->setId($id);
        $this->categoryService->update($dto);

        return response()->json([
            'message' => trans('message.category-update-success'),
        ]);
    }

}
