<?php

namespace App\Contracts\Services;

use App\Dto\PostDto;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;

interface PostServiceContract extends BaseServiceContract {

    /**
     * @param PostDto $dto
     * @return Model|Post
     */
    public function create(PostDto $dto): Model|Post;

    /**
     * @param PostDto $dto
     * @return bool
     */
    public function update(PostDto $dto): bool;

    public function search(mixed $keyword): mixed;
}
