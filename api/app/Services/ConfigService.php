<?php

namespace App\Services;

use App\Models\Config;
use App\Helpers\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Config\ConfigRepositoryInterface;

class ConfigService
{
    public ConfigRepositoryInterface $configRepository;

    /**
     * __construct
     *
     * @param  mixed $configRepository
     * @return void
     */
    public function __construct(ConfigRepositoryInterface $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * @param array $attributes
     *
     * @return Config
     */
    public function create(array $attributes): Config
    {
        return $this->configRepository->create($attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Config
     */
    public function update(array $attributes, int $id): ?Config
    {
        return $this->configRepository->update($attributes, $id);
    }

    /**
     * delete
     *
     * @param  mixed $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->configRepository->delete($id);
    }

    /**
     * showWithPaginate
     *
     * @param  mixed $limit
     * @return LengthAwarePaginator
     */
    public function showWithPaginate(int $limit): LengthAwarePaginator
    {
        return $this->configRepository->showWithPaginate($limit);
    }

    /**
     * find
     *
     * @param  mixed $id
     * @return Config
     */
    public function find(int $id): ?Config
    {
        return $this->configRepository->find($id);
    }

    /**
     * findWhere
     *
     * @param  mixed $attribute
     * @param  mixed $value
     * @return Config
     */
    public function findWhere(string $attribute, string $value): ?Config
    {
        return $this->configRepository->findWhere($attribute, $value);
    }


    /**
     * all
     *
     * @param  mixed $params
     * @return Collection
     */
    public function all(array $params = []): Collection
    {
        return $this->configRepository->all($params);
    }
}
