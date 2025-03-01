<?php

namespace App\Services;

use App\Contracts\Services\PostSearchServiceContract;
use App\Enum\FieldEnum;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class PostSearchService implements PostSearchServiceContract
{
    private array $filters = [];
    private ?string $query = null;
    private int $perPage = 15;

    public function __construct()
    {
        $this->reset();
    }

    public function search(string $query = null): self
    {
        $this->query = $query;
        return $this;
    }

    public function filterByCategory(?int $categoryId): self
    {
        if(!empty($categoryId)) {
            $field = FieldEnum::categoryId->value . ' = ' . $categoryId;
            $this->filters[] = $field;
        }
        return $this;
    }

    public function filterByAuthor(?int $userId): self
    {
        if(!empty($userId)) {
        $field = FieldEnum::userId->value . ' = ' . $userId;
        $this->filters[] = $field;
        }
        return $this;
    }

    public function paginate(?int $perPage = 15): self
    {
        $this->perPage = $perPage;
        return $this;
    }

    public function execute(): LengthAwarePaginator
    {
        $searchParams = [
            'filter' => implode(' AND ', $this->filters),
        ];

        return Post::search($this->query, function ($meiliSearch, $query, $options) use ($searchParams) {
            $options = array_merge($options, $searchParams);
            return $meiliSearch->search($query, $options);
        })->paginate($this->perPage);
    }

    public function reset(): self
    {
        $this->filters = [];
        $this->query = null;
        $this->perPage = 15;
        return $this;
    }
}
