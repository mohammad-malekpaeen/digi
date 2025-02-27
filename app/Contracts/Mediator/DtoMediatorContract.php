<?php

namespace App\Contracts\Mediator;

use App\Dto\CategoryDto;
use App\Dto\PostDto;
use App\Dto\UserDto;
use App\Enum\PostStatus;
use App\Enum\UserSexType;
use App\Enum\UserTypeEnum;

/**
 *
 */
interface DtoMediatorContract {
    /**
     * @param string $email
     * @param string|null $name
     * @param string|null $family
     * @param UserSexType|null $sex
     * @param string|null $mobileNumber
     * @param string|null $nationalCode
     * @param string|null $economicCode
     * @param string|null $birthday
     * @param UserTypeEnum|null $type
     * @param int|null $financeScore
     * @param bool|null $canSell
     * @param bool|null $canBuy
     * @param string|null $nationalVerifiedAt
     * @param string|null $emailVerifiedAt
     * @param string|null $verifiedAt
     * @param array $roles
     * @return UserDto
     */
    public function convertDataToUserDto(
        string $email,
        ?string $name = null,
        ?string $family = null,
        ?UserSexType $sex = null,
        ?string $mobileNumber = null,
        ?string $nationalCode = null,
        ?string $economicCode = null,
        ?string $birthday = null,
        ?UserTypeEnum $type = UserTypeEnum::REAL,
        ?int $financeScore = 0,
        bool $canSell = false,
        bool $canBuy = true,
        ?string $nationalVerifiedAt = null,
        ?string $emailVerifiedAt = null,
        ?string $verifiedAt = null,
        array $roles = [],
    ): UserDto;

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
     * @return PostDto
     */
    public function convertDataToPostDto(
        string $title,
        string $slug,
        PostStatus $status,
        int|null $imageId = null,
        string|null $body = null,
        string|null $excerpt = null,
        string|null $publishedAt = null,
        bool $hasComment = true,
        array $categories = [],
        int|null $categoryId = null,
    ): PostDto;

    /**
     * @param string $title
     * @param string $slug
     * @return CategoryDto
     */
    public function convertDataToCategoryDto(
        string $title,
        string $slug
    ): CategoryDto;
}
