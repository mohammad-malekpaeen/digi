<?php

namespace App\Repositories;

use App\Contracts\Repositories\CategoryRepositoryContract;
use App\Models\Category;

class CategoryRepository extends BaseRepository implements CategoryRepositoryContract {

	/**
	 * @param Category $model
	 */
	public function __construct(Category $model) {
		parent::__construct($model);
	}
}
