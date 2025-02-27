<?php

namespace App\Http\Controllers\API;

use App\Contracts\Mediator\DtoMediatorContract;
use App\Contracts\Services\CategoryServiceContract;
use App\Dto\CategoryDto;
use App\Enum\FieldEnum;
use App\Facades\StringFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CategoryStoreRequest;
use App\Http\Requests\API\CategoryUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{

    /**
     * @param DtoMediatorContract $dtoMediator
     * @param CategoryServiceContract $service
     */
    public function __construct(
        protected DtoMediatorContract     $dtoMediator,
        protected CategoryServiceContract $service,
    )
    {
    }


    /**
     * @param CategoryStoreRequest $request
     */
    public function store(CategoryStoreRequest $request)
    {
        $dto = $this->getDtoFromRequest($request);
        $this->service->create($dto);

        return response(null, Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return CategoryDto
     */
    public function getDtoFromRequest(Request $request): CategoryDto
    {
        return $this->dtoMediator->convertDataToCategoryDto(
            title: $request->input(FieldEnum::title->name),
            slug: StringFacade::slug($request->input(FieldEnum::slug->name)),
        );
    }

    /**
     * @param CategoryUpdateRequest $request
     * @param int $id
     */
    public function update(CategoryUpdateRequest $request, int $id)
    {
        $dto = $this->getDtoFromRequest($request)->setId($id);
        $this->service->update($dto);

        return response(null, Response::HTTP_OK);
    }

}
