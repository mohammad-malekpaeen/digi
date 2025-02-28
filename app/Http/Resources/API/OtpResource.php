<?php

namespace App\Http\Resources\API;

use App\Enum\FieldEnum;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class OtpResource extends BaseResource {

	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array {
		return [
			FieldEnum::message->name    => data_get($this->resource,'message'),
		];
	}
}
