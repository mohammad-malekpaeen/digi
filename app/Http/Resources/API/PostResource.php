<?php

namespace App\Http\Resources\API;

use App\Enum\FieldEnum;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use function data_get;

class PostResource extends BaseResource {

	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array {
		return [
			FieldEnum::message->name    => data_get($this->resource,'message'),
            FieldEnum::data->name =>[
                FieldEnum::id->name => data_get($this->getPosts(),FieldEnum::id->value),
                FieldEnum::categoryId->name => data_get($this->getPosts(),FieldEnum::categoryId->value),
                FieldEnum::userId->name => data_get($this->getPosts(),FieldEnum::userId->value),
                FieldEnum::title->name => data_get($this->getPosts(),FieldEnum::title->value),
                FieldEnum::slug->name => data_get($this->getPosts(),FieldEnum::slug->value),
                FieldEnum::body->name => data_get($this->getPosts(),FieldEnum::body->value),
            ],
		];
	}

    private function getPosts()
    {
        return  data_get($this->resource, FieldEnum::posts->value);
    }
}
