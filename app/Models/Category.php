<?php

namespace App\Models;

use App\Enum\FieldEnum;
use App\Models\Scopes\FilterScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, FilterScope,SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        FieldEnum::title->value,
        FieldEnum::slug->value,
    ];

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

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, FieldEnum::categoryId->value);
    }

}
