<?php

namespace App\Models\Scopes;

use App\Enum\FieldEnum;
use App\Enum\FilterField;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait FilterScope
{

    /**
     * @return array
     */
    abstract public static function getFilterable(): array;

    abstract public static function getColumns(): array;

    /**
     * Apply the filter to a given Eloquent query builder.
     */
    public function scopeFilter(Builder $builder, array $filters): Builder
    {

        foreach ($filters as $column => $value) {
            $value = trim($value);
            $column = trim($column);

            $input = collect(static::getFilterable())->firstWhere(FieldEnum::name->value, $column)['input'] ?? null;
            if ($input == 'number' && !in_array($value, [FilterField::null->value, FilterField::notNull->value])) {
                $value = intval($value);
            }

            if (Str::contains($column, '>')) {
                $relation = str_replace('>', '.', Str::beforeLast($column, '>'));
                $column = Str::afterLast($column, '>');

                $builder->whereHas($relation, function (Builder $builder) use ($value, $column, $input) {
                    $this->handleQuery($builder, $column, $value, $input);
                });
            } else {
                $this->handleQuery($builder, $column, $value, $input);
            }
        }

        return $builder;
    }

    public function handleQuery($builder, $column, $value, $input): void
    {
        match (true) {
            Str::contains($column, FilterField::onlyTrashed->value) => $builder->onlyTrashed(),
            Str::contains($column, FilterField::withTrashed->value) => $builder->withTrashed(),
            Str::startsWith($value, FilterField::in->value) => $this->whereIn(
                $builder,
                $column,
                $value
            ),
            Str::startsWith($value, FilterField::fullText->value) => $this->fullText(
                $builder,
                $column,
                $value
            ),
            Str::startsWith($value, FilterField::null->value) => $this->isNull(
                $builder,
                $column
            ),
            Str::startsWith($value, FilterField::notNull->value) => $this->isNotNull(
                $builder,
                $column
            ),
            Str::startsWith($value, FilterField::lowerThan->value) => $this->lessThan(
                $builder,
                $column,
                $value
            ),
            Str::startsWith($value, FilterField::greaterThan->value) => $this->greaterThan(
                $builder,
                $column,
                $value
            ),
            Str::startsWith($value, FilterField::between->value) => $this->between(
                $builder,
                $column,
                $value
            ),
            default => empty($value) ? $builder : $this->whereEqual($builder, $column, $value, $input),
        };
    }

    /**
     * @param Builder $builder
     * @param string $column
     * @param string $value
     * @param string $input
     * @return Builder
     */
    public function whereEqual(Builder $builder, string $column, string $value, string $input): Builder
    {
        $operation = '=';
        if ($input === 'date') {
            $operation = 'LIKE';
            $value = "%{$value}%";
        }
        $builder->where($column, $operation, $value);
        return $builder;
    }

    /**
     * @param Builder $builder
     * @param string $column
     * @param string $value
     * @return void
     */
    private function whereIn(Builder $builder, string $column, string $value): void
    {
        $value = $this->extractValues($value);
        $builder->whereIn($column, $value);
    }

    /**
     * @param string $value
     * @return array
     */
    private function extractValues(string $value): array
    {
        return explode(',', Str::remove([FilterField::in->value, FilterField::between->value], $value));
    }

    /**
     * @param Builder $builder
     * @param string $column
     * @param string $value
     * @return void
     */
    private function fullText(Builder $builder, string $column, string $value): void
    {
        $value = Str::remove(FilterField::fullText->value, $value);
        $values = explode(' ', $value);
        foreach ($values as $value) {
            $builder->whereFullText($column, $value);
            $this->where($builder, $column, $value, 'or');
        }
    }

    /**
     * @param Builder $builder
     * @param string $column
     * @param string $value
     * @param         $match
     * @return void
     */
    private function where(Builder $builder, string $column, string $value, $match = 'and'): void
    {
        $builder->{$match === 'and' ? 'where' : 'orWhere'}(function ($query) use ($column, $value) {
            foreach ($this->extractValues($value) as $val) {
                $query->orWhere($column, 'ilike', "%{$val}%");
            }
        });
    }

    /**
     * @param Builder $builder
     * @param string $column
     * @return void
     */
    private function isNull(Builder $builder, string $column): void
    {
        $builder->whereNull($column);
    }

    /**
     * @param Builder $builder
     * @param string $column
     * @return void
     */
    private function isNotNull(Builder $builder, string $column): void
    {
        $builder->whereNotNull($column);
    }

    /**
     * @param Builder $builder
     * @param string $column
     * @param string $value
     * @return void
     */
    private function lessThan(Builder $builder, string $column, string $value): void
    {
        $value = Str::remove(FilterField::lowerThan->value, $value);
        $builder->where($column, '<', $value);
    }

    /**
     * @param Builder $builder
     * @param string $column
     * @param string $value
     * @return void
     */
    private function greaterThan(Builder $builder, string $column, string $value): void
    {
        $value = Str::remove(FilterField::greaterThan->value, $value);
        $builder->where($column, '>', $value);
    }

    /**
     * @param Builder $builder
     * @param string $column
     * @param string $value
     * @return void
     */
    private function between(Builder $builder, string $column, string $value): void
    {
        $values = $this->extractValues(Str::remove(FilterField::between->value, $value));
        $builder->whereBetween($column, $values);
    }
}
