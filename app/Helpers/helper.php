<?php

use App\Enum\ColumnFormat;
use App\Enum\FieldEnum;
use App\Enum\FilterField;
use App\Models\Model;
use App\Models\Pivot;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;

if (!function_exists('attr')) {
	function attr($key): Application|array|string|Translator {
		return trans('validation.attributes.' . $key);
	}
}

if (!function_exists('getAllowedFilters')) {
	function getAllowedFilters(Model|Pivot|string $model): Application|array|string|Translator {
		return array_column($model::getFilterable(), 'name');
	}
}

if (!function_exists('filterDto')) {
	function filterDto(
		string $title,
		string $name,
		string|array $type = '',
		string $input = 'text',
		array $items = [],
	): Application|array|string|Translator {
		$dto = [
			FieldEnum::title->name => $title,
			FieldEnum::name->name  => $name,
			FieldEnum::type->name  => $type,
			FieldEnum::input->name => $input,
		];
		return empty($items) ? $dto : array_merge($dto, [FieldEnum::items->name => $items]);
	}
}

if (!function_exists('columnDto')) {
	function columnDto(
		string $title,
		string $name,
		string $resourceName,
		bool $isVisible = true,
		bool $isSortable = true,
		ColumnFormat $format = ColumnFormat::TEXT
	): Application|array|string|Translator {
		return [
			FieldEnum::title->name        => $title,
			FieldEnum::name->name         => $name,
			FieldEnum::resourceName->name => $resourceName,
			FieldEnum::isVisible->name    => $isVisible,
			FieldEnum::isSortable->name   => $isSortable,
			FieldEnum::format->name       => $format->value,
		];
	}
}

if (!function_exists('datatableResource')) {
	function datatableResource(Model|Pivot|string $model): Application|array|string|Translator {
		return [
			'filters' => $model::getFilterable(),
			'columns' => $model::getColumns()
		];
	}
}

if (!function_exists('generateVoucherSignature')) {
	function generateVoucherSignature(string $voucherCode): string {
		return strtoupper(substr(md5($voucherCode), 0, 10));
	}
}

if (!function_exists('convertSlugToEnumName')) {
	function convertSlugToEnumName(string $str): string {
		return str($str)->replace('-', '_')->upper();
	}
}

if (!function_exists('paginateInformation')) {
	function paginateInformation(LengthAwarePaginator $model): array {
		return [
			'current_page' => $model->currentPage(),
			'from'         => $model->firstItem(),
			'last_page'    => $model->lastPage(),
			'path'         => $model->path(),
			'per_page'     => $model->perPage(),
			'to'           => $model->lastItem(),
			'total'        => $model->total(),
		];
	}
}

if (!function_exists('toDateTime')) {
	function toDateTime(mixed $source, mixed $field): ?string {
		return $source->{$field}?->toDateTimeString() ?? null;
	}
}

if (!function_exists('toToman')) {
	function toToman(int|float|null $amount, bool $separator = true): string|int|float|null {
		if (!is_null($amount)) {
			return $separator ? number_format($amount / 10) : $amount / 10;
		}
		return null;
	}
}

if (!function_exists('calculateRemainTime')) {
	function calculateRemainTime(?string $dateTime): array {
		if(empty($dateTime)){
			return [
				FieldEnum::remainTime->name => '',
				FieldEnum::isExpired->name  => false,
			];
		}
		$now = Carbon::now();
		$expireAt = Carbon::parse($dateTime);

		if ($now->greaterThanOrEqualTo($expireAt)) {
			return [
				FieldEnum::remainTime->name => null,
				FieldEnum::isExpired->name  => true,
			];
		} else {
			$remainTimeData = $expireAt->diff($now)->toArray();
			$remainTime = $now
				->setHour(Arr::get($remainTimeData, 'hours'))
				->setMinute(Arr::get($remainTimeData, 'minutes'))
				->setSecond(Arr::get($remainTimeData, 'seconds'));

			return [
				FieldEnum::remainTime->name => (string)$remainTime,
				FieldEnum::isExpired->name  => false,
			];
		}
	}
}

