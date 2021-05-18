<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Post\PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{

    /**
     * PostRepository constructor.
     *
     * @param Post $model
     */
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    /**
     * showByUid
     *
     * @param  mixed $id
     * @return Post
     */
    public function showByUid(string $id): Post
    {
        return Post::where(Post::UNIQUE_ID, $id)
            ->join(User::TABLE, Post::TABLE . '.' . Post::USER_ID, User::TABLE . '.' . User::ID)
            ->select([User::TABLE . '.' . User::NAME, User::TABLE . '.' . User::EMAIL, User::TABLE . '.' . User::PHOTO, Post::TABLE . '.*'])
            ->first();
    }
}
