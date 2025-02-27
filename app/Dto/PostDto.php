<?php

namespace App\Dto;

use App\Enum\FieldEnum;

class PostDto extends BaseDto
{

    /**
     * @param int $category_id
     * @param int $user_id
     * @param string $title
     * @param string $slug
     * @param string $body
     */
    public function __construct(
        protected int    $category_id,
        protected int    $user_id,
        protected string $title,
        protected string $slug,
        protected string $body,
    )
    {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            FieldEnum::categoryId->value => $this->getCategoryId(),
            FieldEnum::userId->value => $this->getUserId(),
            FieldEnum::title->value => $this->getTitle(),
            FieldEnum::slug->value => $this->getSlug(),
            FieldEnum::body->value => $this->getBody(),
        ];
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }


    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }


    /**
     * @return string|null
     */
    public function getBody(): string|null
    {
        return $this->body;
    }


}
