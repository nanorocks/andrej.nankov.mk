<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\BaseRepositoryInterface;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * showByUid
     *
     * @param  mixed $id
     * @return Post
     */
    public function showByUid(string $id): Post;
}
