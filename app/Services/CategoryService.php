<?php

namespace App\Services;

use App\Contracts\Repositories\CategoryRepositoryContract;
use App\Contracts\Services\CategoryServiceContract;
use App\Dto\CategoryDto;
use App\Enum\FieldEnum;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryService extends BaseService implements CategoryServiceContract {

	/**
	 * @param CategoryRepositoryContract $repository
	 */
	public function __construct(CategoryRepositoryContract $repository) {
		parent::__construct($repository);
	}

	/**
	 * @param CategoryDto $dto
	 * @return Model|Category
	 */
	public function create(CategoryDto $dto): Model|Category {
		return $this->repository->create(
			$dto->toArray()
		);
	}

	/**
	 * @param CategoryDto $dto
	 * @return bool
	 */
	public function update(CategoryDto $dto): bool {
		return $this->repository->updateByCondition(
			[[FieldEnum::id->value, '=', $dto->getId()]],
			$dto->toArray()
		);
	}
}
