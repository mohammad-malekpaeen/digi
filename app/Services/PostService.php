<?php

namespace App\Services;

use App\Contracts\Repositories\PostRepositoryContract;
use App\Contracts\Services\PostServiceContract;
use App\Dto\PostDto;
use App\Enum\FieldEnum;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;

class PostService extends BaseService implements PostServiceContract
{

    /**
     * @param PostRepositoryContract $repository
     */
    public function __construct(PostRepositoryContract $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param PostDto $dto
     * @return Model|Post
     */
    public function create(PostDto $dto): Model|Post
    {
        return $this->repository->create(
            $dto->toArray()
        );
    }

    /**
     * @param PostDto $dto
     * @return bool
     */
    public function update(PostDto $dto): bool
    {
        return $this->repository->updateByCondition(
            [[FieldEnum::id->value, '=', $dto->getId()]],
            $dto->toArray()
        );
    }

    public function search(mixed $keyword): mixed
    {
        return $this->repository->search($keyword)->paginateRaw(100);
    }
}
