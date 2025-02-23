<?php

namespace App\Http\Requests\API;

use App\Enum\FieldEnum;
use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class OtpStoreRequest extends BaseRequest {

	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, ValidationRule|array<mixed>|string>
	 */
	public function rules(): array {
		return [
			FieldEnum::email->name => ['required','email']
		];
	}
}
