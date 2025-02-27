<?php

namespace App\Dto;

use App\Enum\FieldEnum;

class CategoryDto extends BaseDto {

    /**
     * @param string $title
     * @param string $slug
     */
	public function __construct(
		protected string $title,
		protected string $slug,
	) {}

	/**
	 * @return array
	 */
	public function toArray(): array {
		return [
			FieldEnum::title->value      => $this->getTitle(),
			FieldEnum::slug->value       => $this->getSlug(),
		];
	}

	/**
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}

	/**
	 * @return string
	 */
	public function getSlug(): string {
		return $this->slug;
	}

}
