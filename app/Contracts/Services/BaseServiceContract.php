<?php

namespace App\Contracts\Services;

use App\Enum\CacheEnum;
use App\Enum\EloquentScope;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Throwable;

interface BaseServiceContract {

	/**
	 * @param array $conditions
	 * @return bool
	 */
	public function exists(array $conditions = []): bool;

	/**
	 * @param array $conditions
	 * @param array $payload
	 * @return Model
	 */
	public function firstOrCreate(array $conditions, array $payload): Model;

	/**
	 * @param int   $id
	 * @param array $relations
	 * @param array $relationCount
	 * @param array $columns
	 * @return Model
	 */
	public function findById(
		int $id,
		array $relations = [],
		array $relationCount = [],
		array $columns = ['*']
	): Model;

	/**
	 * @param string $column
	 * @param string $value
	 * @param array  $relations
	 * @param array  $relationCount
	 * @param array  $columns
	 * @return Model
	 * @throws Throwable
	 */
	public function findByColumn(
		string $column,
		string $value,
		array $relations = [],
		array $relationCount = [],
		array $columns = ['*']
	): Model;

	/**
	 * @param string $order
	 * @param array  $conditions
	 * @param array  $relations
	 * @param array  $relationCount
	 * @param array  $columns
	 * @return Model
	 * @throws Throwable
	 */
	public function findOrFailedByCondition(
		string $order = 'id desc',
		array $conditions = [],
		array $relations = [],
		array $relationCount = [],
		array $columns = ['*'],
	): Model;

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
		array $columns = ['*'],
	): ?Model;

	/**
	 * @param array $relations
	 * @param array $columns
	 * @return Collection
	 */
	public function all(array $relations = [], array $columns = ['*']): Collection;

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
		array $columns = ['*'],
	): Collection;

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
		array $columns = ['*'],
	): Paginator;

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
	): Paginator|Collection;

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
	 * @param EloquentScope $scope
	 * @return $this
	 */
	public function pushScope(EloquentScope $scope): static;

	/**
	 * @param EloquentScope $scope
	 * @return $this
	 */
	public function popTrash(EloquentScope $scope): static;

	/**
	 * @return array
	 */
	public function getScopes(): array;

	/**
	 * @return void
	 */
	public function disableCache(): void;

	/**
	 * @return void
	 */
	public function enableCache(): void;

	/**
	 * @param CacheEnum   $cacheEnum
	 * @param string|null $name
	 * @return void
	 */
	public function setCacheTag(CacheEnum $cacheEnum, string|null $name = null): void;
}
