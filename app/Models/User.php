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
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return array
     */
    public static function getFilterable(): array {
        return [];
    }

    /**
     * @return array
     */
    public static function getColumns(): array {
        return [];
    }

}
