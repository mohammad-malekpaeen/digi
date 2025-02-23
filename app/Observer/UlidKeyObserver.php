<?php

namespace App\Observer;

use App\Models\Model;
use Illuminate\Support\Str;

class UlidKeyObserver
{
    public function creating(Model $model)
    {
        $model->id = (string) Str::ulid();
    }
}
