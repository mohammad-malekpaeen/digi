<?php

namespace App\Dto;

use App\Enum\FieldEnum;

class CategoryDto extends BaseDto {

	/**
	 * @param string      $title
	 * @param string      $slug
	 * @param string|null $body
	 * @param int|null    $imageId
	 * @param int|null    $upstreamId
	 */
	public function __construct(
		protected string $title,
		protected string $slug,
		protected string|null $body = null,
		protected int|null $imageId = null,
		protected int|null $upstreamId = null,
	) {}

	/**
	 * @return array
	 */
	public function toArray(): array {
		return [
			FieldEnum::title->value      => $this->getTitle(),
			FieldEnum::slug->value       => $this->getSlug(),
			FieldEnum::body->value       => $this->getBody(),
			FieldEnum::imageId->value    => $this->getImageId(),
			FieldEnum::upstreamId->value => $this->getUpstreamId(),
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

	/**
	 * @return string|null
	 */
	public function getBody(): string|null {
		return $this->body;
	}

	/**
	 * @return int|null
	 */
	public function getImageId(): int|null {
		return $this->imageId;
	}

	/**
	 * @return int|null
	 */
	public function getUpstreamId(): int|null {
		return $this->upstreamId;
	}
}
