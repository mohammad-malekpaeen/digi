<?php

namespace App\Contracts\Services;

use App\Dto\CategoryDto;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

interface CategoryServiceContract extends BaseServiceContract {

    /**
     * @param CategoryDto $dto
     * @return Model|Category
     */
	public function create(CategoryDto $dto): Model|Category;

    /**
     * @param CategoryDto $dto
     * @return bool
     */
	public function update(CategoryDto $dto): bool;
}
