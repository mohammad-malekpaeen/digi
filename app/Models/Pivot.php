<?php

namespace App\Models;

use App\Builder\OptimizedBuilder;
use App\Models\Scopes\FilterScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot as BasePivot;

abstract class Pivot extends BasePivot {

	use FilterScope;

	public static function getAllowedFilters(): array {
		return array_column(self::getFilterable(), 'name');
	}

	/**
	 * Create a new Eloquent query builder for the model.
	 *
	 * @param Builder|object $query
	 * @return OptimizedBuilder
	 */
	public function newEloquentBuilder($query): OptimizedBuilder {
		return new OptimizedBuilder($query);
	}
}
