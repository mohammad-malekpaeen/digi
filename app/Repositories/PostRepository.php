<?php

namespace App\Repositories;

use App\Contracts\Repositories\PostRepositoryContract;
use App\Enum\FieldEnum;
use App\Models\Post;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository implements PostRepositoryContract {

	/**
	 * @param Post $model
	 */
	public function __construct(Post $model) {
		parent::__construct($model);
	}

    public function search(mixed $keyword): mixed{
       return $this->model->search($keyword);
    }
}
