<?php

namespace App\Contracts\Services;

use Illuminate\Pagination\LengthAwarePaginator;

interface PostSearchServiceContract
{

    public function search(string $query = null): self;

    public function execute(): LengthAwarePaginator;

    public function filterByCategory(?int $categoryId): self;

    public function filterByAuthor(?int $userId): self;

    public function paginate(?int $perPage = 15): self;
}
