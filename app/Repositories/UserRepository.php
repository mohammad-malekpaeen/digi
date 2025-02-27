<?php

namespace App\Repositories;

use App\Contracts\Repositories\CategoryRepositoryContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Models\Category;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryContract {

	/**
	 * @param User $model
	 */
	public function __construct(User $model) {
		parent::__construct($model);
	}
}
