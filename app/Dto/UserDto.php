<?php

namespace App\Dto;

use App\Enum\FieldEnum;

class UserDto extends BaseDto
{

    /**
     * @param string|null $name
     * @param string|null $email
     * @param string|null $password
     */
    public function __construct(
        protected ?string $name = null,
        protected ?string $email = null,
        protected ?string $password = null,
    )
    {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            FieldEnum::name->value => $this->getName(),
            FieldEnum::email->value => $this->getEmail(),
            FieldEnum::password->value => $this->getPassword(),
        ];
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $name
     * @return UserDto
     */
    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string|null $email
     * @return UserDto
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string|null $password
     * @return UserDto
     */
    public function setPassword(?string $password): self
    {
        $this->password = bcrypt($password);
        return $this;
    }

}
