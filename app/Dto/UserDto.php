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
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }



    /**
     * @return array
     */
    function toArray(): array
    {
        return [
            FieldEnum::name->value => $this->getName(),
            FieldEnum::email->value => $this->getEmail(),
            FieldEnum::password->value => $this->getPassword(),
        ];
    }
}
