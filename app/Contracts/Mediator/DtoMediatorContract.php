<?php

namespace App\Contracts\Mediator;

use App\Dto\UserDto;
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
}
