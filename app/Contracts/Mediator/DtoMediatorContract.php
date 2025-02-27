<?php

namespace App\Contracts\Mediator;

use App\Dto\CategoryDto;
use App\Dto\PostDto;
use App\Dto\UserDto;

/**
 *
 */
interface DtoMediatorContract
{
    /**
     * @param string|null $name
     * @param string|null $email
     * @param string|null $password
     * @return UserDto
     */
    public function convertDataToUserDto(
        ?string  $name = null,
        ?string $email = null,
        ?string $password = null,
    ): UserDto;

    /**
     * @param int $category_id
     * @param int $user_id
     * @param string $title
     * @param string $slug
     * @param string $body
     * @return PostDto
     */
    public function convertDataToPostDto(
        int $category_id,
        int $user_id,
        string $title,
        string $slug,
        string $body,
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
