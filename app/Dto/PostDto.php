<?php

namespace App\Dto;

use App\Enum\FieldEnum;
use App\Enum\PostStatus;

class PostDto extends BaseDto {

	/**
	 * @param string         $title
	 * @param string         $slug
	 * @param PostStatus $status
	 * @param int|null       $imageId
	 * @param string|null    $body
	 * @param string|null    $excerpt
	 * @param string|null    $publishedAt
	 * @param bool           $hasComment
	 * @param array          $categories
	 * @param int|null       $categoryId
	 */
	public function __construct(
		protected string $title,
		protected string $slug,
		protected PostStatus $status,
		protected int|null $imageId = null,
		protected string|null $body = null,
		protected string|null $excerpt = null,
		protected string|null $publishedAt = null,
		protected bool $hasComment = true,
		protected array $categories = [],
		protected int|null $categoryId = null,
	) {}

	/**
	 * @return array
	 */
	public function toArray(): array {
		return [
			FieldEnum::title->value       => $this->getTitle(),
			FieldEnum::slug->value        => $this->getSlug(),
			FieldEnum::status->value      => $this->getStatus()->value,
			FieldEnum::body->value        => $this->getBody(),
			FieldEnum::excerpt->value     => $this->getExcerpt(),
			FieldEnum::publishedAt->value => $this->getPublishedAt(),
			FieldEnum::hasComment->value  => $this->hasComment(),
			FieldEnum::imageId->value     => $this->getImageId(),
			FieldEnum::categoryId->value  => $this->getCategoryId(),
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
	 * @return PostStatus
	 */
	public function getStatus(): PostStatus {
		return $this->status;
	}

	/**
	 * @return string|null
	 */
	public function getBody(): string|null {
		return $this->body;
	}

	/**
	 * @return string|null
	 */
	public function getExcerpt(): string|null {
		return $this->excerpt;
	}

	/**
	 * @return string|null
	 */
	public function getPublishedAt(): string|null {
		return $this->publishedAt;
	}

	/**
	 * @return bool
	 */
	public function hasComment(): bool {
		return $this->hasComment;
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
	private function getCategoryId(): ?int {
		return $this->categoryId;
	}

	/**
	 * @return array
	 */
	public function getCategories(): array {
		return $this->categories;
	}
}
