<?php

namespace App\Http\Requests\API;

use App\Enum\FieldEnum;
use App\Enum\PostStatus;
use App\Http\Requests\BaseRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class PostStoreRequest extends BaseRequest {


	/**
	 * @var array
	 */
	protected array $shouldBeSlug = [FieldEnum::slug->name];

	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool {
		return auth()->check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, ValidationRule|array|string>
	 */
	public function rules(): array {
		return [
			FieldEnum::title->name             => [
				'required',
				'string',
				'max:255'
			],
			FieldEnum::slug->name              => [
				'required',
				'string',
				'max:255',
				Rule::unique(Post::class, FieldEnum::slug->value)->withoutTrashed(),
			],
			FieldEnum::status->name            => [
				'required',
				Rule::in(PostStatus::names())
			],
			FieldEnum::body->name              => [
				'required',
				'string',
				'max:4294967295'
			],
			FieldEnum::excerpt->name           => [
				'nullable',
				'string',
				'max:16777215'
			],
			FieldEnum::publishedAt->name       => [
				'nullable',
				'date_format:Y-m-d H:i:s',
			],

			FieldEnum::categoryId->name        => [
				'sometimes',
				'nullable',
				'integer',
				Rule::exists(Category::class, FieldEnum::id->value)->withoutTrashed()
			],
		];
	}
}
