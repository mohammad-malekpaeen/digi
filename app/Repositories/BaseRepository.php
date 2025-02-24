<?php

namespace App\Repositories;

use AllowDynamicProperties;
use App\Contracts\Repositories\BaseRepositoryContract;
use App\Enum\EloquentScope;
use App\Enum\FieldEnum;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Throwable;

#[AllowDynamicProperties] abstract class BaseRepository implements BaseRepositoryContract {

    /** @var array */
    protected array $scopes = [];

    /**
     * @param Model $model
     */
    public function __construct(Model $model) {
        $this->model = $model;
    }

    /**
     * @param int   $id
     * @param array $relations
     * @param array $relationCount
     * @param array $columns
     * @return Model
     */
    public function findById(int $id,
                             array $relations = [],
                             array $relationCount = [],
                             array $columns = ['*']): Model {
        return $this->model
            ->newQuery()
            ->select($columns)
            ->with($relations)
            ->withCount($relationCount)
            ->where(FieldEnum::id->value, '=', $id)
            ->firstOrFail();
    }

    /**
     * @param string $order
     * @param array  $conditions
     * @param array  $relations
     * @param array  $relationCount
     * @param array  $columns
     * @return Model|null
     */
    public function findByCondition(
        string $order = 'id desc',
        array $conditions = [],
        array $relations = [],
        array $relationCount = [],
        array $columns = ['*']
    ): ?Model {
        return $this->model->newQuery()
            ->select($columns)
            ->with($relations)
            ->withCount($relationCount)
            ->where($conditions)
            ->orderByRaw($order)
            ->first();
    }

    /**
     * @param int    $perPage
     * @param string $order
     * @param array  $conditions
     * @param array  $relations
     * @param array  $relationCount
     * @param array  $columns
     * @return Paginator|Collection
     */
    public function filter(
        int $perPage = 12,
        string $order = 'id desc',
        array $conditions = [],
        array $relations = [],
        array $relationCount = [],
        array $columns = ['*']
    ): Paginator|Collection {
        $query = $this->model
            ->newQuery()
            ->select($columns)
            ->with($relations)
            ->withCount($relationCount)
            ->filter($conditions)
            ->orderByRaw($order);

        return $perPage != 0 ? $query->paginate($perPage) : $query->get();
    }

    /**
     * @param int    $perPage
     * @param string $order
     * @param array  $conditions
     * @param array  $relations
     * @param array  $relationCount
     * @param array  $columns
     * @return Paginator
     */
    public function paginate(
        int $perPage = 12,
        string $order = 'id desc',
        mixed $conditions = [],
        array $relations = [],
        array $relationCount = [],
        array $columns = ['*']
    ): Paginator {
        return $this->model->newQuery()
            ->select($columns)
            ->with($relations)
            ->withCount($relationCount)
            ->where($conditions)
            ->orderByRaw($order)
            ->paginate($perPage);
    }

    /**
     * @param int    $limit
     * @param string $order
     * @param mixed  $conditions
     * @param array  $relations
     * @param array  $relationCount
     * @param array  $columns
     * @return Collection
     */
    public function get(
        int $limit = 0,
        string $order = 'id desc',
        mixed $conditions = [],
        array $relations = [],
        array $relationCount = [],
        array $columns = ['*']
    ): Collection {
        $query = $this->model->newQuery()
            ->select($columns)
            ->with($relations)
            ->withCount($relationCount)
            ->where($conditions)
            ->orderByRaw($order);
        $query->when($limit > 0, fn($q) => $q->take($limit));
        return $query->get();
    }

    /**
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): Model {
        $model = $this->model->newQuery()->create($payload);
        return $model;
    }

    /**
     * @param array $payload
     * @return void
     */
    public function insert(array $payload): void {
        $this->model->newQuery()->insert($payload);
    }

    /**
     * @param array $conditions
     * @param array $payload
     * @param bool  $isBulk
     * @return bool
     * @throws Throwable
     */
    public function updateByCondition(array $conditions, array $payload, bool $isBulk = false): bool {
        $isExists = $this->model->newQuery()->where($conditions)->exists();
        throw_if(!$isExists, \Exception::class);

        if ($isBulk) {
            return $this->model->newQuery()->where($conditions)->update($payload);
        }

        $result = $this->model->newQuery()->where($conditions)->get();

        return DB::transaction(function () use ($result, $payload) {
            $result->map(fn($item) => $item->update($payload));
            return true;
        });
    }

    /**
     * @param array $conditions
     * @return bool
     */
    public function exists(array $conditions = []): bool {
        $query = $this->model->newQuery()->where($conditions);
        return $this->handleScopes($query)->exists();
    }

    /**
     * @param Builder|EloquentBuilder $query
     * @return Builder|EloquentBuilder
     */
    protected function handleScopes(Builder|EloquentBuilder $query): Builder|EloquentBuilder {
        foreach ($this->getScopes() as $scope) {
            match ($scope) {
                EloquentScope::withTrashed->name => $query->withTrashed(),
                EloquentScope::onlyTrashed->name => $query->onlyTrashed(),
            };
        }

        return $query;
    }

    /**
     * @return array
     */
    public function getScopes(): array {
        return $this->scopes;
    }

    /**
     * @param array $conditions
     * @param array $payload
     * @return bool
     */
    public function update(array $conditions, array $payload): bool {
        $result = (bool)$this->model->newQuery()->where($conditions)->update($payload);
        return $result;
    }

    /**
     * @param array|int $ids
     * @return void
     */
    public function deleteByIds(array|int $ids): void {
        $this->model->destroy($ids);
    }

    /**
     * @param array $conditions
     * @return void
     */
    public function deleteByCondition(array $conditions): void {
        $ids = $this->model->newQuery()->where($conditions)->pluck('id');
        $this->model->destroy($ids);
    }

    /**
     * @param array $conditions
     * @return void
     */
    public function restoreByCondition(array $conditions): void {
        $result = $this->model->newQuery()->onlyTrashed()->where($conditions)->get();
        DB::transaction(function () use ($result) {
            $result->map(fn($item) => $item->restore());
        });
    }

    /**
     * @param array $conditions
     * @param array $payload
     * @return Model
     */
    public function firstOrCreate(array $conditions, array $payload): Model {
        $model = $this->model->newQuery()->firstOrCreate($conditions, $payload);
        return $model;
    }

    /**
     * @param EloquentScope $scope
     * @return void
     */
    public function pushScopes(EloquentScope $scope): void {
        $this->scopes[] = $scope->name;
        $this->scopes = array_unique($this->scopes);
    }

    /**
     * @param EloquentScope $scope
     * @return void
     */
    public function popTrash(EloquentScope $scope): void {
        $this->scopes = array_diff($this->scopes, [$scope]);
    }

    /**
     * @param array  $payload
     * @param string $relation
     * @param int    $id
     * @return mixed
     */
    public function sync(array $payload, string $relation, int $id): mixed {
        $model = $this->model->newQuery()->findOrFail($id);
        $result = $model->{$relation}()->sync($payload);
        return $result;
    }

    /**
     * @param array  $conditions
     * @param string $column
     * @return float
     */
    public function average(array $conditions, string $column): float {
        return $this->model->newQuery()->where($conditions)->avg($column);
    }

    /**
     * @param array $conditions
     * @param array $payloads
     * @return Model
     */
    public function updateOrCreate(array $conditions, array $payloads): Model {
        $model = $this->model->newQuery()->updateOrCreate($conditions, $payloads);
        return $model;
    }
}
