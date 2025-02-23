<?php

namespace App\Models;

use App\Enum\FieldEnum;
use App\Enum\UserSexType;
use App\Enum\UserTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        FieldEnum::name->value,
        FieldEnum::family->value,
        FieldEnum::sex->value,
        FieldEnum::email->value,
        FieldEnum::mobileNumber->value,
        FieldEnum::nationalCode->value,
        FieldEnum::economicCode->value,
        FieldEnum::birthday->value,
        FieldEnum::type->value,
        FieldEnum::financeScore->value,
        FieldEnum::canSell->value,
        FieldEnum::canBuy->value,
        FieldEnum::nationalVerifiedAt->value,
        FieldEnum::emailVerifiedAt->value,
        FieldEnum::verifiedAt->value,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        FieldEnum::emailVerifiedAt->value    => 'datetime',
        FieldEnum::nationalVerifiedAt->value => 'datetime',
        FieldEnum::verifiedAt->value         => 'datetime',
        FieldEnum::type->value               => UserTypeEnum::class,
        FieldEnum::sex->value                => UserSexType::class,
        FieldEnum::canBuy->value             => 'boolean',
        FieldEnum::canSell->value            => 'boolean',
    ];

}
