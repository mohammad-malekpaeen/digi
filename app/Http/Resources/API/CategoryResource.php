<?php

namespace App\Http\Resources\API;

use App\Enum\FieldEnum;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use function data_get;

class CategoryResource extends BaseResource {

	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array {
		return [
			FieldEnum::message->name    => data_get($this->resource,'message'),
            FieldEnum::data->name =>[
                FieldEnum::id->name => data_get($this->getCategories(),FieldEnum::id->value),
                FieldEnum::title->name => data_get($this->getCategories(),FieldEnum::title->value),
                FieldEnum::slug->name => data_get($this->getCategories(),FieldEnum::slug->value),
            ],
		];
	}

    private function getCategories()
    {
        return  data_get($this->resource, FieldEnum::categories->value);
    }
}
