<?php

namespace App\Http\Requests;

use App\Facades\StringFacade;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

abstract class BaseRequest extends FormRequest {

	/**
	 * @var array
	 */
	protected array $shouldBeRelativePath = [];

	/**
	 * @var array
	 */
	protected array $shouldBeArray = [];

	/**
	 * @var array
	 */
	protected array $shouldBeBoolean = [];

	/**
	 * @var array
	 */
	protected array $shouldBeSlug = [];

	/**
	 * @var array
	 */
	protected array $shouldBeRial = [];

	/**
	 * @var array
	 */
	protected array $shouldBeFormatCurrency = [];
	protected array $shouldBeEmptyToNull = [];

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	abstract public function authorize(): bool;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	abstract public function rules(): array;

	/**
	 * @param ValidationFactory $factory
	 * @return Validator
	 */
	protected function createDefaultValidator(ValidationFactory $factory): Validator {
		$this->convertToRelativePath();
		$this->convertToBoolean();
		$this->convertToSlug();
		$this->convertToFormatCurrency();
		$this->convertToArray();
		$this->convertToNullFromEmpty();

		return parent::createDefaultValidator($factory);
	}

	/**
	 * @return void
	 */
	public function convertToRelativePath(): void {
		foreach ($this->shouldBeRelativePath as $property) {
			$items = $this->input($property);

			$items = is_array($items)
				? array_map(fn($item) => $item && StringFacade::getRelativePath($item), $items)
				: StringFacade::getRelativePath($items);

			$this->merge([$property => $items]);
		}
	}

	/**
	 * @return void
	 */
	public function convertToBoolean(): void {
		foreach ($this->shouldBeBoolean as $property) {
			$isArray = Str::contains($property, '.');

			if ($isArray) {
				list($treeKey, $branchKey) = explode('.', $property);

				$input = $this->input($treeKey);

				if (is_array($input)) {
					for ($i = 0; $i < count($input); $i++) {
						$input[$i][$branchKey] = filter_var(data_get($input[$i], $branchKey, false),
							FILTER_VALIDATE_BOOLEAN);
					}
					$this->merge([$treeKey => $input]);
				} else {
					$input[$branchKey] = filter_var(data_get($input, $branchKey, false), FILTER_VALIDATE_BOOLEAN);
					$this->merge([$treeKey => $input]);
				}
			} else {
				$this->merge([$property => filter_var($this->input($property, false), FILTER_VALIDATE_BOOLEAN)]);
			}
		}
	}

	/**
	 * @return void
	 */
	public function convertToSlug(): void {
		foreach ($this->shouldBeSlug as $property) {
			$isArray = Str::contains($property, '.');

			if ($isArray) {
				list($treeKey, $branchKey) = explode('.', $property);

				$input = $this->input($treeKey);
				$input[$branchKey] = $input[$branchKey] ? Str::slug($input[$branchKey]) : null;
				$this->merge([$treeKey => $input]);
			} else {
				$item = $this->filled($property) ? Str::slug($this->input($property)) : null;
				$this->merge([$property => $item]);
			}
		}
	}

	/**
	 * @return void
	 */
	public function convertToArray(): void {
		foreach ($this->shouldBeArray as $property) {
			$this->merge([
				$property => $this->input($property) ?? []
			]);
		}
	}

	/**
	 * @return void
	 */
	public function convertToNullFromEmpty(): void {
		foreach ($this->shouldBeEmptyToNull as $property) {
			if(empty($this->input($property))) {
				$this->merge([$property => null]);
			}
		}
	}

	/**
	 * @return void
	 */
	public function convertToFormatCurrency(): void {
		foreach ($this->shouldBeFormatCurrency as $property) {
			$isArray = Str::contains($property, '.');

			if ($isArray) {
				list($treeKey, $branchKey) = explode('.', $property);

				$input = $this->input($treeKey);

				if (is_array($input)) {
					for ($i = 0; $i < count($input); $i++) {
						if (!is_numeric(data_get($input[$i], $branchKey, false))) {
						$input[$i][$branchKey] = intval(preg_replace('/\D/',
							'',
							data_get($input[$i], $branchKey, false)));
						}
					}
					$this->merge([$treeKey => $input]);
				} else {
					if (!is_numeric(data_get($input, $branchKey, false))) {
						$input[$branchKey] = intval(preg_replace('/\D/',
							'',
							data_get($input, $branchKey, false)));
						$this->merge([$treeKey => $input]);
					}
				}
			} else {
				if(!is_numeric($this->input($property))){
				$this->merge([
					$property => $this->has($property)
						? intval(preg_replace('/\D/', '', $this->input($property)))
						: null
				]);
				}
			}
		}
	}
}
