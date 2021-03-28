<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Post\PostRepositoryInterface;

class PostService
{
    public PostRepositoryInterface $postRepository;

    /**
     * __construct
     *
     * @param  mixed $postRepository
     * @return void
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param array $attributes
     *
     * @return Post
     */
    public function create(array $attributes): Post
    {
        return $this->postRepository->create($attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Post
     */
    public function update(array $attributes, int $id): ?Post
    {
        return $this->postRepository->update($attributes, $id);
    }

    /**
     * delete
     *
     * @param  mixed $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->postRepository->delete($id);
    }

    /**
     * showWithPaginate
     *
     * @param  mixed $limit
     * @return LengthAwarePaginator
     */
    public function showWithPaginate(int $limit): LengthAwarePaginator
    {
        return $this->postRepository->showWithPaginate($limit);
    }

    /**
     * find
     *
     * @param  mixed $id
     * @return Post
     */
    public function find(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

    /**
     * findWhere
     *
     * @param  mixed $attribute
     * @param  mixed $value
     * @return Post
     */
    public function findWhere(string $attribute, string $value): ?Post
    {
        return $this->postRepository->findWhere($attribute, $value);
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
        return $this->postRepository->paginateWithOrder($limit, $param, $order);
    }

    /**
     * showByUid
     *
     * @param  mixed $id
     * @return Post
     */
    public function showByUid(string $id): Post
    {
        return $this->postRepository->showByUid($id);
    }
}
