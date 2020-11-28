<?php

namespace App\Http\Controllers\ClientSide;

use App\Models\Post;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function getPosts()
    {
        return Post::orderBy(Post::DATE, 'desc')->paginate(4);
    }
}
