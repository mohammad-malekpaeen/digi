<?php

namespace App\Contracts\Services;

use App\Dto\UserDto;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface UserServiceContract extends BaseServiceContract
{

    /**
     * @param UserDto $dto
     * @return Model|User
     */
    public function findOrCreateByEmail(UserDto $dto): Model|User;

    /**
     * @param UserDto $dto
     * @return bool
     */
    public function update(UserDto $dto): bool;


}
