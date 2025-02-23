<?php

namespace App\Dto;

use App\Enum\FieldEnum;
use App\Enum\UserSexType;
use App\Enum\UserTypeEnum;

class UserDto extends BaseDto {

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
     */
	public function __construct(
		protected string $email,
		protected ?string $name = null,
		protected ?string $family = null,
		protected ?UserSexType $sex = null,
		protected ?string $mobileNumber = null,
		protected ?string $nationalCode = null,
		protected ?string $economicCode = null,
		protected ?string $birthday = null,
		protected ?UserTypeEnum $type = UserTypeEnum::REAL,
		protected ?int $financeScore = 0,
		protected bool $canSell = false,
		protected bool $canBuy = true,
		protected ?string $nationalVerifiedAt = null,
		protected ?string $emailVerifiedAt = null,
		protected ?string $verifiedAt = null,
		protected array $roles = [],
	) {}

	/**
	 * @param string|null $verifiedAt
	 * @return void
	 */
	public function setVerifiedAt(?string $verifiedAt): void {
		$this->verifiedAt = $verifiedAt;
	}

    /**
     * @return string|null
     */
	public function getMobileNumber(): ?string {
		return $this->mobileNumber;
	}

	/**
	 * @return string|null
	 */
	public function getName(): ?string {
		return $this->name;
	}

	/**
	 * @return string|null
	 */
	public function getFamily(): ?string {
		return $this->family;
	}

    /**
     * @return string
     */
	public function getEmail(): string {
		return $this->email;
	}

	/**
	 * @return string|null
	 */
	public function getNationalCode(): ?string {
		return $this->nationalCode;
	}

	/**
	 * @return string|null
	 */
	public function getEconomicCode(): ?string {
		return $this->economicCode;
	}

	/**
	 * @return string|null
	 */
	public function getBirthday(): ?string {
		return $this->birthday;
	}

	/**
	 * @return UserTypeEnum|null
	 */
	public function getType(): ?UserTypeEnum {
		return $this->type;
	}

	/**
	 * @return int|null
	 */
	public function getFinanceScore(): ?int {
		return $this->financeScore;
	}

	/**
	 * @return bool|null
	 */
	public function getCanSell(): ?bool {
		return $this->canSell;
	}

	/**
	 * @return bool|null
	 */
	public function getCanBuy(): ?bool {
		return $this->canBuy;
	}

	/**
	 * @return string|null
	 */
	public function getNationalVerifiedAt(): ?string {
		return $this->nationalVerifiedAt;
	}

	/**
	 * @return string|null
	 */
	public function getEmailVerifiedAt(): ?string {
		return $this->emailVerifiedAt;
	}

	/**
	 * @return string|null
	 */
	public function getVerifiedAt(): ?string {
		return $this->verifiedAt;
	}

	/**
	 * @return array
	 */
	public function getRoles(): array {
		return $this->roles;
	}

	/**
	 * @return UserSexType|null
	 */
	public function getSex(): ?UserSexType {
		return $this->sex;
	}

	/**
	 * @return array
	 */
	function toArray(): array {
		return [
			FieldEnum::mobileNumber->value       => $this->getMobileNumber(),
			FieldEnum::name->value               => $this->getName(),
			FieldEnum::family->value             => $this->getFamily(),
			FieldEnum::sex->value                => $this->getSex()->value ?? null,
			FieldEnum::email->value              => $this->getEmail(),
			FieldEnum::nationalCode->value       => $this->getNationalCode(),
			FieldEnum::economicCode->value       => $this->getEconomicCode(),
			FieldEnum::birthday->value           => $this->getBirthday(),
			FieldEnum::type->value               => $this->getType(),
			FieldEnum::financeScore->value       => $this->getFinanceScore(),
			FieldEnum::canSell->value            => $this->getCanSell(),
			FieldEnum::canBuy->value             => $this->getCanBuy(),
			FieldEnum::nationalVerifiedAt->value => $this->getNationalVerifiedAt(),
			FieldEnum::emailVerifiedAt->value    => $this->getEmailVerifiedAt(),
			FieldEnum::verifiedAt->value         => $this->getVerifiedAt(),
		];
	}
}
