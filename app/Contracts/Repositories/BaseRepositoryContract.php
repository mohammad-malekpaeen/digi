<?php

namespace App\Contracts\Repositories;

use App\Enum\EloquentScope;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryContract
{

    /**
     * @param array $conditions
     * @return bool
     */
    public function exists(array $conditions = []): bool;

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
        array $columns = ['*'],
    ): Model;

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
    ): ?Model;

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
    ): Collection;

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
    ): Paginator;

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
    ): Paginator|Collection;

    /**
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): Model;

    /**
     * @param array $payload
     * @return void
     */
    public function insert(array $payload): void;

    /**
     * @param array $conditions
     * @param array $payload
     * @param bool $isBulk
     * @return bool
     */
    public function updateByCondition(array $conditions, array $payload, bool $isBulk = false): bool;

    /**
     * @param array $conditions
     * @param array $payload
     * @return bool
     */
    public function update(array $conditions, array $payload): bool;

    /**
     * @param array|int $ids
     * @return void
     */
    public function deleteByIds(array|int $ids): void;

    /**
     * @param array $conditions
     * @return void
     */
    public function deleteByCondition(array $conditions): void;

    /**
     * @param array $conditions
     * @return void
     */
    public function restoreByCondition(array $conditions): void;

    /**
     * @param array $conditions
     * @param array $payload
     * @return Model
     */
    public function firstOrCreate(array $conditions, array $payload): Model;

    /**
     * @param EloquentScope $scope
     * @return void
     */
    public function pushScopes(EloquentScope $scope): void;

    /**
     * @param EloquentScope $scope
     * @return void
     */
    public function popTrash(EloquentScope $scope): void;

    /**
     * @return array
     */
    public function getScopes(): array;

    /**
     * @param array $payload
     * @param string $relation
     * @param int $id
     * @return mixed
     */
    public function sync(array $payload, string $relation, int $id): mixed;

    /**
     * @param array $conditions
     * @param string $column
     * @return float
     */
    public function average(array $conditions, string $column): float;

    /**
     * @param array $conditions
     * @param array $payloads
     * @return Model
     */
    public function updateOrCreate(array $conditions, array $payloads): Model;
}
