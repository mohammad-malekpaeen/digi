<?php

namespace App\Contracts\Repositories;

interface PostRepositoryContract extends BaseRepositoryContract
{
    public function search(mixed $keyword): mixed;
}
