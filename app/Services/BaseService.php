<?php

namespace App\Services;

use App\Contracts\Repositories\BaseRepositoryContract;
use App\Contracts\Services\BaseServiceContract;
use App\Enum\CacheEnum;
use App\Enum\EloquentScope;
use App\Exceptions\ModelNotFoundException;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Throwable;

abstract class BaseService implements BaseServiceContract
{

    /**
     * @var BaseRepositoryContract
     */
    protected BaseRepositoryContract $repository;

    /**
     * @param BaseRepositoryContract $repository
     */
    public function __construct(BaseRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $conditions
     * @return bool
     */
    public function exists(array $conditions = []): bool
    {
        return $this->repository->exists($conditions);
    }

    /**
     * @param int $id
     * @param array $relations
     * @param array $relationCount
     * @param array $columns
     * @return Model
     */
    public function findById(
        int   $id,
        array $relations = [],
        array $relationCount = [],
        array $columns = ['*']
    ): Model
    {
        return $this->repository->findById(
            id: $id,
            relations: $relations,
            relationCount: $relationCount,
            columns: $columns
        );
    }

    /**
     * @param string $column
     * @param string $value
     * @param array $relations
     * @param array $relationCount
     * @param array $columns
     * @return Model
     * @throws Throwable
     */
    public function findByColumn(
        string $column,
        string $value,
        array  $relations = [],
        array  $relationCount = [],
        array  $columns = ['*']
    ): Model
    {
        $item = $this->repository->findByCondition(
            conditions: [[$column, '=', $value]],
            relations: $relations,
            relationCount: $relationCount,
            columns: $columns
        );

        throw_if(is_null($item), ModelNotFoundException::class);

        return $item;
    }

    /**
     * @param string $order
     * @param array $conditions
     * @param array $relations
     * @param array $relationCount
     * @param array $columns
     * @return Model|null
     */
    public function findByCondition(
        string $order = 'id desc',
        array  $conditions = [],
        array  $relations = [],
        array  $relationCount = [],
        array  $columns = ['*'],
    ): ?Model
    {
        return $this->repository->findByCondition(
            order: $order,
            conditions: $conditions,
            relations: $relations,
            relationCount: $relationCount,
            columns: $columns
        );
    }

    /**
     * @param string $order
     * @param array $conditions
     * @param array $relations
     * @param array $relationCount
     * @param array $columns
     * @return Model
     * @throws Throwable
     */
    public function findOrFailedByCondition(
        string $order = 'id desc',
        array  $conditions = [],
        array  $relations = [],
        array  $relationCount = [],
        array  $columns = ['*'],
    ): Model
    {
        $item = $this->repository->findByCondition(
            order: $order,
            conditions: $conditions,
            relations: $relations,
            relationCount: $relationCount,
            columns: $columns
        );
        throw_if(is_null($item), ModelNotFoundException::class);
        return $item;
    }

    /**
     * @param array $relations
     * @param array $columns
     * @return Collection
     */
    public function all(array $relations = [], array $columns = ['*']): Collection
    {
        return $this->repository->get(
            relations: $relations,
            columns: $columns
        );
    }

    /**
     * @param int $limit
     * @param string $order
     * @param mixed $conditions
     * @param array $relations
     * @param array $relationCount
     * @param array $columns
     * @return Collection
     */
    public function get(
        int    $limit = 0,
        string $order = 'id desc',
        mixed  $conditions = [],
        array  $relations = [],
        array  $relationCount = [],
        array  $columns = ['*'],
    ): Collection
    {
        return $this->repository->get(
            limit: $limit,
            order: $order,
            conditions: $conditions,
            relations: $relations,
            relationCount: $relationCount,
            columns: $columns
        );
    }

    /**
     * @param int $perPage
     * @param string $order
     * @param array $conditions
     * @param array $relations
     * @param array $relationCount
     * @param array $columns
     * @return Paginator
     */
    public function paginate(
        int    $perPage = 12,
        string $order = 'id desc',
        mixed  $conditions = [],
        array  $relations = [],
        array  $relationCount = [],
        array  $columns = ['*'],
    ): Paginator
    {
        return $this->repository->paginate(
            perPage: $perPage,
            order: $order,
            conditions: $conditions,
            relations: $relations,
            relationCount: $relationCount,
            columns: $columns
        );
    }

    /**
     * @param int $perPage
     * @param string $order
     * @param array $conditions
     * @param array $relations
     * @param array $relationCount
     * @param array $columns
     * @return Paginator|Collection
     */
    public function filter(
        int    $perPage = 12,
        string $order = 'id desc',
        array  $conditions = [],
        array  $relations = [],
        array  $relationCount = [],
        array  $columns = ['*']
    ): Paginator|Collection
    {
        return $this->repository->filter(
            perPage: $perPage,
            order: $order,
            conditions: $conditions,
            relations: $relations,
            relationCount: $relationCount,
            columns: $columns
        );
    }

    /**
     * @param array|int $ids
     * @return void
     */
    public function deleteByIds(array|int $ids): void
    {
        $this->repository->deleteByIds($ids);
    }

    /**
     * @param array $conditions
     * @return void
     */
    public function deleteByCondition(array $conditions): void
    {
        $this->repository->deleteByCondition($conditions);
    }

    /**
     * @param array $conditions
     * @return void
     */
    public function restoreByCondition(array $conditions): void
    {
        $this->repository->restoreByCondition($conditions);
    }

    /**
     * @param array $payload
     * @return void
     */
    public function insert(array $payload): void
    {
        $this->repository->insert($payload);
    }

    /**
     * @param array $conditions
     * @param array $payload
     * @return Model
     */
    public function firstOrCreate(array $conditions, array $payload): Model
    {
        return $this->repository->firstOrCreate($conditions, $payload);
    }

    /**
     * @param EloquentScope $scope
     * @return $this
     */
    public function pushScope(EloquentScope $scope): static
    {
        $this->repository->pushScopes($scope);
        return $this;
    }

    /**
     * @param EloquentScope $scope
     * @return $this
     */
    public function popTrash(EloquentScope $scope): static
    {
        $this->repository->popTrash($scope);
        return $this;
    }

    /**
     * @return array
     */
    public function getScopes(): array
    {
        return $this->repository->getScopes();
    }

    /**
     * @return void
     */
    public function disableCache(): void
    {
        $this->repository->disableCache();
    }

    /**
     * @return void
     */
    public function enableCache(): void
    {
        $this->repository->enableCache();
    }

    /**
     * @param CacheEnum $cacheEnum
     * @param string|null $name
     * @return void
     */
    public function setCacheTag(CacheEnum $cacheEnum, string|null $name = null): void
    {
        $this->repository->setCacheTag($cacheEnum, $name);
    }
}
