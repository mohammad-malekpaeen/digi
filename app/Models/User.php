<?php

namespace App\Models;

use App\Enum\ColumnFormat;
use App\Enum\FieldEnum;
use App\Enum\FilterField;
use App\Models\Scopes\FilterScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, FilterScope, SoftDeletes;

    /**
     * The transibutes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        FieldEnum::name->value,
        FieldEnum::email->value,
        FieldEnum::password->value,
    ];

    /**
     * The transibutes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The transibutes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
      ];

    /**
     * @return array
     */
    public static function getFilterable(): array {
        return [
            filterDto(
                title: trans(FieldEnum::id->name),
                name : FieldEnum::id->value,
                type : FilterField::where->value,
                input: 'number'
            ),
            filterDto(
                title: trans(FieldEnum::name->name),
                name : FieldEnum::name->value,
                type : FilterField::fullText->value
            ),
            filterDto(
                title: trans(FieldEnum::family->name),
                name : FieldEnum::family->value,
                type : FilterField::fullText->value
            ),
            filterDto(
                title: trans(FieldEnum::uniqueId->name),
                name : FieldEnum::uniqueId->value,
                type : FilterField::fullText->value
            ),
            filterDto(
                title: trans(FieldEnum::email->name),
                name : FieldEnum::email->value,
                type : FilterField::fullText->value
            ),
            filterDto(
                title: trans(FieldEnum::mobileNumber->name),
                name : FieldEnum::mobileNumber->value,
                type : FilterField::fullText->value
            ),
            filterDto(
                title: trans(FieldEnum::nationalCode->name),
                name : FieldEnum::nationalCode->value,
                type : FilterField::fullText->value
            ),
            filterDto(
                title: trans(FieldEnum::economicCode->name),
                name : FieldEnum::economicCode->value,
                type : FilterField::fullText->value
            ),
            filterDto(
                title: trans(FieldEnum::birthday->name),
                name : FieldEnum::birthday->value,
                type : FilterField::fullText->value
            ),
            filterDto(
                title: trans(FieldEnum::canSell->name),
                name : FieldEnum::canSell->value,
                type : FilterField::where->value,
                input: 'checkbox',
            ),
            filterDto(
                title: trans(FieldEnum::canBuy->name),
                name : FieldEnum::canBuy->value,
                type : FilterField::where->value,
                input: 'checkbox',
            ),
            filterDto(
                title: trans(FieldEnum::createdAt->name),
                name : FieldEnum::createdAt->value,
                type : [
                    FilterField::where->value,
                    FilterField::between->value,
                    FilterField::greaterThan->value,
                    FilterField::lowerThan->value
                ],
                input: 'date'
            ),
            filterDto(
                title: trans(FilterField::onlyTrashed->name),
                name : FilterField::onlyTrashed->value,
                type : FilterField::where->value
            ),
            filterDto(
                title: trans(FilterField::withTrashed->name),
                name : FilterField::withTrashed->value,
                type : FilterField::where->value
            ),
        ];
    }

    /**
     * @return array
     */
    public static function getColumns(): array {
        return [
            columnDto(
                title       : trans(FieldEnum::id->name),
                name        : FieldEnum::id->value,
                resourceName: FieldEnum::id->name,
            ),
            columnDto(
                title       : trans(FieldEnum::name->name),
                name        : FieldEnum::name->value,
                resourceName: FieldEnum::name->name,
            ),
            columnDto(
                title       : trans(FieldEnum::family->name),
                name        : FieldEnum::family->value,
                resourceName: FieldEnum::family->name,
            ),
            columnDto(
                title       : trans(FieldEnum::uniqueId->name),
                name        : FieldEnum::uniqueId->value,
                resourceName: FieldEnum::uniqueId->name,
            ),
            columnDto(
                title       : trans(FieldEnum::mobileNumber->name),
                name        : FieldEnum::mobileNumber->value,
                resourceName: FieldEnum::mobileNumber->name,
            ),
            columnDto(
                title       : trans(FieldEnum::nationalCode->name),
                name        : FieldEnum::nationalCode->value,
                resourceName: FieldEnum::nationalCode->name,
            ),
            columnDto(
                title       : trans(FieldEnum::canBuy->name),
                name        : FieldEnum::canBuy->value,
                resourceName: FieldEnum::canBuy->name,
                format      : ColumnFormat::BOOLEAN,
            ),
            columnDto(
                title       : trans(FieldEnum::canSell->name),
                name        : FieldEnum::canSell->value,
                resourceName: FieldEnum::canSell->name,
                format      : ColumnFormat::BOOLEAN,
            ),
            columnDto(
                title       : trans(FieldEnum::createdAt->name),
                name        : FieldEnum::createdAt->value,
                resourceName: FieldEnum::createdAt->name,
                format      : ColumnFormat::DATE_JALALI
            ),
        ];
    }

}
