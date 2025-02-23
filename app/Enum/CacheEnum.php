<?php

namespace App\Enum;

enum CacheEnum: string {

	case PUBLIC   = 'public';
	case POST = 'post';
	case CATEGORY    = 'category';
	/**
	 * @param string|null $name
	 * @return array
	 */
	public function getTag(string $name = null): array {
		if (!is_null($name)) {
			return [$this->value, $name];
		}
		return explode(':', $this->value);
	}
}
