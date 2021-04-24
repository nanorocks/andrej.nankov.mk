<?php

namespace App\Repositories\Project;

use App\Models\Project;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Project\ProjectRepositoryInterface;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{

    /**
     * ProjectRepository constructor.
     *
     * @param Project $model
     */
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

    /**
     * showWithPaginate
     *
     * @param  mixed $limit
     * @return LengthAwarePaginator
     */
    public function showWithPaginate(int $limit): LengthAwarePaginator
    {
        return $this->model->orderBy(Project::DATE, 'DESC')->paginate($limit);
    }
}
