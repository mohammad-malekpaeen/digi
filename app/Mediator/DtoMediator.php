<?php

namespace App\Mediator;

use App\Contracts\Mediator\DtoMediatorContract;
use App\Dto\CategoryDto;
use App\Dto\PostDto;
use App\Dto\UserDto;

/**
 *
 */
class DtoMediator implements DtoMediatorContract
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
    ): UserDto
    {
        return new UserDto(
            name: $name,
            email: $email,
            password: $password
        );
    }

    public function convertDataToPostDto(
        int $category_id,
        int $user_id,
        string $title,
        string $slug,
        string $body,
    ): PostDto
    {
        return new PostDto (
            category_id: $category_id,
            user_id: $user_id,
            title: $title,
            slug: $slug,
            body: $body,
        );
    }

    public function convertDataToCategoryDto(
        string $title,
        string $slug
    ): CategoryDto
    {
        return new CategoryDto (
            title: $title,
            slug: $slug
        );
    }
}
