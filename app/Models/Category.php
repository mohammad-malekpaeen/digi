<?php

namespace App\Models;

use App\Enum\FieldEnum;
use App\Enum\FilterField;
use App\Models\Scopes\FilterScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    use HasFactory, FilterScope, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        FieldEnum::upstreamId->value,
        FieldEnum::title->value,
        FieldEnum::slug->value,
    ];

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
                input: 'number',
            ),
            filterDto(
                title: attr(FieldEnum::upstreamId->name),
                name: FieldEnum::upstreamId->value,
                type: [
                    FilterField::where->value,
                    FilterField::null->value,
                    FilterField::notNull->value
                ]
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
                title: attr('upstream'),
                name: 'upstream' . '>' . FieldEnum::title->value,
                type: FilterField::fullText->value
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
                resourceName: FieldEnum::id->name,
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
                title: attr(FieldEnum::upstreamId->name),
                name: FieldEnum::upstreamId->value,
                resourceName: 'upstream' . '>' . FieldEnum::title->name,
                isSortable: false
            ),
        ];
    }

    /**
     * @return BelongsTo
     */
    public function upstream(): BelongsTo
    {
        return $this->belongsTo(Category::class, FieldEnum::upstreamId->value);
    }

    public function posts():HasMany{
        return $this->hasMany(Post::class,FieldEnum::categoryId->value);
    }


}
