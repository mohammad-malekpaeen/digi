<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\UserServiceContract;
use App\Dto\UserDto;
use App\Enum\FieldEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserService extends BaseService implements UserServiceContract
{

    /**
     * @param UserRepositoryContract $repository
     */
    public function __construct(
        UserRepositoryContract $repository,
    )
    {
        parent::__construct($repository);
    }

    /**
     * @param UserDto $dto
     * @return Model|User
     */
    public function findOrCreateByEmail(UserDto $dto): Model|User
    {
        $user = $this->repository->findByCondition(
            'id desc',
            [[FieldEnum::email->value, '=', $dto->getEmail()]
            ]
        );

        if (!$user) {
            $user = $this->repository->create([
                FieldEnum::type->value => $dto->getType(),
                FieldEnum::name->value => $dto->getName(),
                FieldEnum::family->value => $dto->getFamily(),
                FieldEnum::email->value => $dto->getEmail(),
            ]);
        }

        return $user;
    }


    /**
     * @param UserDto $dto
     * @return bool
     */
    public function update(UserDto $dto): bool
    {
        $this->repository->updateByCondition(
            [[FieldEnum::id->value, '=', $dto->getId()]],
            $dto->toArray()
        );
        return true;
    }

}
