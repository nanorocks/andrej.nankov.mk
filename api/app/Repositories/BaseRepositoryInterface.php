<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface BaseRepositoryInterface
 * @package App\Repositories
 */
interface BaseRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * update
     *
     * @param  mixed $attributes
     * @param  mixed $id
     * @return Model
     */
    public function update(array $attributes, int $id): ?Model;

    /**
     * delete
     *
     * @param  mixed $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * showWithPaginate
     *
     * @param  mixed $limit
     * @return LengthAwarePaginator
     */
    public function showWithPaginate(int $limit): LengthAwarePaginator;

    /**
     * @param $id
     * @return Model
     */
    public function find(int $id): ?Model;

    /**
     * first
     *
     * @return Model
     */
    public function first(): Model;

    /**
     * findWhere
     *
     * @param  mixed $attribute
     * @param  mixed $value
     * @return Model
     */
    public function findWhere(string $attribute, string $value): ?Model;
}
