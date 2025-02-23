<?php

namespace Core\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ForeignIdColumnDefinition;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * @param  int  $length
         * @return \Illuminate\Database\Schema\ColumnDefinition;
         */
        Blueprint::macro('ulid', function ($length = 26) {
            /* @var $this Blueprint * */
            return $this->string('id', $length)->primary();
        });

        /**
         * @param  string  $column
         * @return \Illuminate\Database\Schema\ColumnDefinition|\Illuminate\Database\Schema\ForeignIdColumnDefinition;
         */
        Blueprint::macro('foreignUlid', function ($column) {
            /* @var $this Blueprint * */
            return $this->addColumnDefinition(new ForeignIdColumnDefinition($this, [
                'type' => 'string',
                'length' => 26,
                'name' => $column,
            ]));
        });

        /**
         * Add JsonPaginator as a macro to Query Builder
         *
         * @retrun LengthAwarePaginator
         */
        Builder::macro(config('json-api-paginate.method_name'), function (?int $maxResults = null, ?int $defaultSize = null): LengthAwarePaginator {
            $maxResults = $maxResults ?? config('json-api-paginate.max_results');
            $defaultSize = $defaultSize ?? config('json-api-paginate.default_size');
            $numberParameter = config('json-api-paginate.number_parameter');
            $sizeParameter = config('json-api-paginate.size_parameter');
            $paginationParameter = config('json-api-paginate.pagination_parameter');
            $paginationMethod = config('json-api-paginate.use_simple_pagination') ? 'simplePaginate' : 'paginate';

            $size = (int) request()->input($paginationParameter.'.'.$sizeParameter, $defaultSize);

            $size = $size > $maxResults ? $maxResults : $size;

            $paginator = $this
                ->{$paginationMethod}($size, ['*'], $paginationParameter.'.'.$numberParameter)
                ->setPageName($paginationParameter.'['.$numberParameter.']')
                ->appends(Arr::except(request()->input(), $paginationParameter.'.'.$numberParameter));

            if (! is_null(config('json-api-paginate.base_url'))) {
                $paginator->setPath(config('json-api-paginate.base_url'));
            }

            return $paginator;
        });
    }
}
