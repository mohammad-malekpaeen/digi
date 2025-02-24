<?php

namespace App\Http\Requests\Dashboard;

use App\Enum\FieldEnum;
use App\Enum\PermissionEnum;
use App\Enum\RouteNameEnum;
use App\Facades\UserFacade;
use App\Http\Requests\BaseRequest;
use App\Models\BlogCategory;
use App\Models\File;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class BlogCategoryUpdateRequest extends BaseRequest {

	/**
	 * @var array
	 */
	protected array $shouldBeSlug = [FieldEnum::slug->name];

	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool {
		return UserFacade::hasPermission($this->user(), PermissionEnum::BLOG_CATEGORY_UPDATE);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, ValidationRule|array|string>
	 */
	public function rules(): array {
		return [
			FieldEnum::title->name      => [
				'required',
				'string',
				'max:255',
			],
			FieldEnum::slug->name       => [
				'required',
				Rule::unique(BlogCategory::class, FieldEnum::slug->value)
					->ignore($this->route(RouteNameEnum::blogCategory->toSnakeCase()))
					->withoutTrashed(),
			],
			FieldEnum::body->name       => [
				'nullable',
				'string',
				'max:4294967295',
			],
			FieldEnum::imageId->name    => [
				'nullable',
				'integer',
				Rule::exists(File::class, FieldEnum::id->value)
					->withoutTrashed(),
			],
			FieldEnum::upstreamId->name => [
				'nullable',
				'integer',
				Rule::exists(BlogCategory::class, FieldEnum::id->value)
					->withoutTrashed(),
			],
		];
	}
}
