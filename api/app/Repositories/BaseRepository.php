<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function update(array $attributes, int $id): ?Model
    {
        $model = $this->model->findOrFail($id);
        $model->update($attributes);
        return $model;
    }

    /**
     * delete
     *
     * @param  mixed $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $model = $this->model->findOrFail($id);
        return $model->delete();
    }

    /**
     * showWithPaginate
     *
     * @param  mixed $limit
     * @return LengthAwarePaginator
     */
    public function showWithPaginate(int $limit): LengthAwarePaginator
    {
        return $this->model->paginate($limit);
    }

    /**
     * find
     *
     * @param  mixed $id
     * @return Model
     */
    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * @param $id
     * @return Model
     */
    public function first(): Model
    {
        return $this->model->all()->first();
    }

    /**
     * findWhere
     *
     * @param  mixed $attribute
     * @param  mixed $value
     * @return Model
     */
    public function findWhere(string $attribute, string $value): ?Model
    {
        return $this->model->where($attribute, $value)->first();
    }

    /**
     * paginateWithOrder
     *
     * @param  mixed $limit
     * @param  mixed $param
     * @param  mixed $order
     * @return LengthAwarePaginator
     */
    public function paginateWithOrder(string $limit, string $param, string $order = 'desc'): LengthAwarePaginator
    {
        return $this->model->orderBy($param, $order)->paginate($limit);
    }

    public function all(array $params = []): Collection
    {
        return $this->model->all(...$params);
    }
}
