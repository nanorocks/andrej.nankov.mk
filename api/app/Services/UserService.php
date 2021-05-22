<?php

namespace App\Services;

use App\Domain\Dtos\Profile\UpdateDto;
use App\Models\User;
use App\Helpers\Client;
use App\Repositories\User\UserRepositoryInterface;

class UserService
{
    public UserRepositoryInterface $userRepository;

    /**
     * __construct
     *
     * @param  mixed $userRepository
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $attributes
     *
     * @return User
     */
    public function update(UpdateDto $dto): ?User
    {
        return $this->userRepository->update($dto->toArray(), $dto->id);
    }

    /**
     * findWhere
     *
     * @param  mixed $attribute
     * @param  mixed $value
     * @return User
     */
    public function findWhere(string $attribute, string $value): ?User
    {
        return $this->userRepository->findWhere($attribute, $value);
    }

    /**
     * first
     *
     * @return User
     */
    public function first(): User
    {
        return $this->userRepository->first();
    }
}
