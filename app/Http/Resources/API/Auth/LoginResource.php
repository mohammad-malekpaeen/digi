<?php

namespace App\Http\Resources\API\Auth;

use App\Enum\FieldEnum;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class LoginResource extends BaseResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            FieldEnum::message->name => data_get($this->resource, FieldEnum::message->value),
            FieldEnum::user->name =>[
                FieldEnum::name->name => data_get($this->getUser(),FieldEnum::name->value),
                FieldEnum::email->name => data_get($this->getUser(),FieldEnum::email->value),
            ],
            FieldEnum::authorization->name => [
                FieldEnum::token->name => data_get($this->resource, FieldEnum::token->value),
                FieldEnum::type->name => 'bearer',
            ],
        ];
    }

    private function getUser()
    {
      return  data_get($this->resource, FieldEnum::user->value);
    }


}
