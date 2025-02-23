<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Carbon;

abstract class Model extends Eloquent
{
    protected $dateFormat = 'Y-m-d H:i:s.u';

    /**
     * Prepare a date for array / JSON serialization.
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return Carbon::instance($date)->toIso8601String();
    }
}
