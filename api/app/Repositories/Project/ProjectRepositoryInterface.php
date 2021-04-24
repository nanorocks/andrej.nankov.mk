<?php

namespace App\Repositories\Project;

use App\Repositories\BaseRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProjectRepositoryInterface extends BaseRepositoryInterface
{
    public function showWithPaginate(int $limit): LengthAwarePaginator;
}
