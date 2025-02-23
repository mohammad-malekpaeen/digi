<?php

namespace App\Enum;

trait BaseEnum {

	public static function array(): array {
		return array_combine(self::names(), self::values());
	}

	public static function names(): array {
		return array_column(self::cases(), 'name');
	}

	public static function values(): array {
		return array_column(self::cases(), 'value');
	}

	public static function tryFromName(null|string $name = null): self|null {
		if (!is_null($name)) {
			return constant("static::$name");
		}
		return null;
	}
}
