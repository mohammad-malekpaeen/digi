<?php

namespace App\Models;

use App\Enum\ColumnFormat;
use App\Enum\FieldEnum;
use App\Enum\FilterField;
use App\Models\Scopes\FilterScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;


class Post extends Model
{

    use  SoftDeletes, FilterScope, Searchable;

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
        return [
            filterDto(
                title: attr(FieldEnum::id->name),
                name: FieldEnum::id->value,
                type: FilterField::where->value,
                input: 'number'
            ),
            filterDto(
                title: attr(FieldEnum::title->name),
                name: FieldEnum::title->value,
                type: FilterField::fullText->value
            ),
            filterDto(
                title: attr(FieldEnum::slug->name),
                name: FieldEnum::slug->value,
                type: FilterField::fullText->value
            ),
            filterDto(
                title: attr(FieldEnum::createdAt->name),
                name: FieldEnum::createdAt->value,
                type: [
                    FilterField::where->value,
                    FilterField::between->value,
                    FilterField::greaterThan->value,
                    FilterField::lowerThan->value
                ],
                input: 'date'
            ),
            filterDto(
                title: attr(FilterField::onlyTrashed->name),
                name: FilterField::onlyTrashed->value,
                type: FilterField::where->value
            ),
            filterDto(
                title: attr(FilterField::withTrashed->name),
                name: FilterField::withTrashed->value,
                type: FilterField::where->value
            ),
        ];
    }

    /**
     * @return array
     */
    public static function getColumns(): array
    {
        return [
            columnDto(
                title: attr(FieldEnum::id->name),
                name: FieldEnum::id->value,
                resourceName: FieldEnum::id->name
            ),
            columnDto(
                title: attr(FieldEnum::title->name),
                name: FieldEnum::title->value,
                resourceName: FieldEnum::title->name,
            ),
            columnDto(
                title: attr(FieldEnum::slug->name),
                name: FieldEnum::slug->value,
                resourceName: FieldEnum::slug->name,
            ),
            columnDto(
                title: attr(FieldEnum::status->name),
                name: FieldEnum::status->value,
                resourceName: FieldEnum::status->name,
            ),
            columnDto(
                title: attr(FieldEnum::hasComment->name),
                name: FieldEnum::hasComment->value,
                resourceName: FieldEnum::hasComment->name,
                format: ColumnFormat::BOOLEAN
            ),
            columnDto(
                title: attr('image'),
                name: FieldEnum::imageId->value,
                resourceName: 'image',
                format: ColumnFormat::IMAGE
            ),
            columnDto(
                title: attr(FieldEnum::createdAt->name),
                name: FieldEnum::createdAt->value,
                resourceName: FieldEnum::createdAt->name,
                format: ColumnFormat::DATE_JALALI
            ),
            columnDto(
                title: attr(FieldEnum::publishedAt->name),
                name: FieldEnum::publishedAt->value,
                resourceName: FieldEnum::publishedAt->name,
                format: ColumnFormat::DATE_JALALI
            ),
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, FieldEnum::categoryId->value);
    }
}
