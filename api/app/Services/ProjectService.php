<?php

namespace App\Services;

use App\Helpers\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Project\ProjectRepositoryInterface;

class ProjectService
{
    public ProjectRepositoryInterface $projectRepository;

    /**
     * __construct
     *
     * @param  mixed $projectRepository
     * @return void
     */
    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param array $attributes
     *
     * @return Project
     */
    public function create(array $attributes): Project
    {
        return $this->projectRepository->create($attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Project
     */
    public function update(array $attributes, int $id): ?Project
    {
        return $this->projectRepository->update($attributes, $id);
    }

    /**
     * delete
     *
     * @param  mixed $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->projectRepository->delete($id);
    }

    /**
     * showWithPaginate
     *
     * @param  mixed $limit
     * @return LengthAwarePaginator
     */
    public function showWithPaginate(int $limit): LengthAwarePaginator
    {
        return $this->projectRepository->showWithPaginate($limit);
    }

    /**
     * find
     *
     * @param  mixed $id
     * @return Project
     */
    public function find(int $id): ?Project
    {
        return $this->projectRepository->find($id);
    }

    /**
     * findWhere
     *
     * @param  mixed $attribute
     * @param  mixed $value
     * @return Project
     */
    public function findWhere(string $attribute, string $value): ?Project
    {
        return $this->projectRepository->findWhere($attribute, $value);
    }

    /**
     * paginateWithOrder
     *
     * @param  mixed $limit
     * @param  mixed $param
     * @param  mixed $order
     * @return LengthAwarePaginator
     */
    public function paginateWithOrder(Request $request, string $param, string $order = 'desc'): LengthAwarePaginator
    {
        $limit = $request->input('limit') ?? 4;
        $page = $request->input('page') ?? 1;

        return $this->projectRepository->paginateWithOrder($limit, $param, $order);
    }
}
