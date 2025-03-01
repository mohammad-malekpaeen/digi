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
        FieldEnum::categoryId->value,
        FieldEnum::userId->value,
        FieldEnum::title->value,
        FieldEnum::slug->value,
        FieldEnum::body->value,
    ];

    protected $casts = [
    ];

    public function searchableAs(): string
    {
        return 'posts';
    }

    public function toSearchableArray()
    {
        return [
            FieldEnum::title->value => $this->{FieldEnum::title->value},
            FieldEnum::slug->value => $this->{FieldEnum::slug->value},
            FieldEnum::body->value => $this->{FieldEnum::body->value},
            FieldEnum::categoryId->value => $this->{FieldEnum::categoryId->value},
            FieldEnum::userId->value => $this->{FieldEnum::userId->value},
        ];
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
