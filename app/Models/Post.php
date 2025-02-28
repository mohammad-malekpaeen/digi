<?php

namespace App\Models;

use App\Enum\FieldEnum;
use App\Models\Scopes\FilterScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;


class Post extends Model
{
    use FilterScope, Searchable,SoftDeletes;

    protected $fillable = [
        FieldEnum::title->value,
        FieldEnum::slug->value,
        FieldEnum::body->value,
        FieldEnum::categoryId->value,
    ];

    protected $casts = [
    ];

    public function searchableAs(): string
    {
        return 'posts';
    }

    public function toSearchableArray()
    {
        return $this->toArray();
    }

    /**
     * @return array
     */
    public static function getFilterable(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public static function getColumns(): array
    {
        return [];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, FieldEnum::categoryId->value);
    }
}
